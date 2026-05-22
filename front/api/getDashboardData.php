<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../../back/config/database.php';

try {
    $data = [];

    // KPIs
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM orcamento WHERE st_orcamento IN ('Aberto', 'Aprovado')");
    $orcamentosAtivos = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    $stmt = $pdo->query("SELECT SUM(vl_total) as total FROM orcamento WHERE MONTH(dt_pedido) = MONTH(NOW()) AND YEAR(dt_pedido) = YEAR(NOW())");
    $faturamentoMes = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

    $stmt = $pdo->query("SELECT COUNT(*) as total FROM produto");
    $produtosEstoque = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    $stmt = $pdo->query("SELECT COUNT(*) as total FROM vw_estoque_baixo");
    $produtosBaixo = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    $stmt = $pdo->query("SELECT COUNT(*) as total FROM agenda WHERE DATE(dt_compromisso) = CURDATE()");
    $compromissosHoje = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

    $stmt = $pdo->query("
        SELECT
            (SELECT COUNT(*) FROM orcamento WHERE MONTH(dt_pedido) = MONTH(NOW()) AND YEAR(dt_pedido) = YEAR(NOW())) as mes_atual,
            (SELECT COUNT(*) FROM orcamento WHERE MONTH(dt_pedido) = MONTH(DATE_SUB(NOW(), INTERVAL 1 MONTH)) AND YEAR(dt_pedido) = YEAR(DATE_SUB(NOW(), INTERVAL 1 MONTH))) as mes_anterior
    ");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $crescimentoOrc = $result['mes_anterior'] > 0
        ? round((($result['mes_atual'] - $result['mes_anterior']) / $result['mes_anterior']) * 100)
        : 0;

    $data['kpis'] = [
        'orcamentos_ativos'  => (int)$orcamentosAtivos,
        'crescimento_orc'    => $crescimentoOrc,
        'faturamento_mes'    => (float)$faturamentoMes,
        'produtos_estoque'   => (int)$produtosEstoque,
        'produtos_baixo'     => (int)$produtosBaixo,
        'compromissos_hoje'  => (int)$compromissosHoje
    ];

    // Faturamento por mês
    $stmt = $pdo->query("
        SELECT DATE_FORMAT(dt_pedido, '%m') as mes, SUM(vl_total) as total
        FROM orcamento
        WHERE dt_pedido >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
        GROUP BY DATE_FORMAT(dt_pedido, '%Y%m')
        ORDER BY dt_pedido ASC
    ");
    $faturamento = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // monta mapa mesNum => total
    $mapFaturamento = [];
    foreach ($faturamento as $item) {
        $mapFaturamento[(int)$item['mes']] = (float)$item['total'];
    }

    $mesesNomes   = ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'];
    $ultimos6Meses = [];
    $vals          = [];

    for ($i = 5; $i >= 0; $i--) {
        $mesNum          = (int)date('n', strtotime("-$i months"));
        $ultimos6Meses[] = $mesesNomes[$mesNum - 1];
        $vals[]          = $mapFaturamento[$mesNum] ?? 0;
    }

    $data['faturamento'] = [
        'meses' => $ultimos6Meses, // 6 nomes de mês
        'vals'  => $vals           // 6 valores, 0 onde não há dados
    ];

    // Pedras mais vendidas
    $stmt = $pdo->query("
        SELECT p.nm_pedra as nome, COUNT(o.id_orcamento) as qtd
        FROM pedra p
        LEFT JOIN orcamento o ON p.id_pedra = o.id_pedra
        GROUP BY p.id_pedra
        ORDER BY qtd DESC
        LIMIT 3
    ");
    $pedras = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $totalPedras = array_sum(array_column($pedras, 'qtd'));
    $data['pedras'] = array_map(fn($p) => [
        'nome' => $p['nome'],
        'pct'  => $totalPedras > 0 ? round(($p['qtd'] / $totalPedras) * 100) : 0
    ], $pedras);

    // Orçamentos recentes
    $stmt = $pdo->query("
        SELECT o.id_orcamento, c.nm_cliente as cliente,
               p.nm_pedra as pedra, o.vl_total as valor,
               o.st_orcamento as status
        FROM orcamento o
        JOIN cliente c ON o.cd_cliente = c.cd_cliente
        JOIN pedra p ON o.id_pedra = p.id_pedra
        ORDER BY o.dt_pedido DESC
        LIMIT 4
    ");
    $data['orcamentos'] = array_map(fn($o) => [
        'cliente' => $o['cliente'],
        'pedra'   => $o['pedra'],
        'valor'   => 'R$ ' . number_format($o['valor'], 2, ',', '.'),
        'status'  => $o['status']
    ], $stmt->fetchAll(PDO::FETCH_ASSOC));

    // Vendedores e comissões
    $stmt = $pdo->query("
        SELECT v.nm_vendedor as nome, v.vl_comissao as comissao,
               COALESCE(SUM(o.vl_total), 0) as total_vendas
        FROM vendedor v
        LEFT JOIN venda vd ON v.id_vendedor = vd.id_vendedor
        LEFT JOIN orcamento o ON vd.id_orcamento = o.id_orcamento
        GROUP BY v.id_vendedor
        ORDER BY total_vendas DESC
        LIMIT 3
    ");
    $data['vendedores'] = array_map(fn($v) => [
        'nome'     => $v['nome'],
        'comissao' => $v['comissao'] . '%',
        'valor'    => 'R$ ' . number_format(($v['total_vendas'] * $v['comissao']) / 100, 2, ',', '.')
    ], $stmt->fetchAll(PDO::FETCH_ASSOC));

    echo json_encode($data, JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['erro' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
}