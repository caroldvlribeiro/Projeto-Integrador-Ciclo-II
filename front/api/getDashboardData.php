<?php
header('Content-Type: application/json; charset=utf-8');

require_once '../../back/config/database.php';

try {
    $data = [];

    // 0. KPI CARDS
    // - Orçamentos ativos (status = 'Aberto' ou 'Aprovado')
    $query = "SELECT COUNT(*) as total FROM orcamentos WHERE st_orcamento IN ('Aberto', 'Aprovado')";
    $stmt = $pdo->query($query);
    $orcamentosAtivos = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // - Faturamento do mês (mês atual)
    $query = "
        SELECT SUM(vl_total) as total 
        FROM orcamentos 
        WHERE MONTH(dt_orcamento) = MONTH(NOW()) 
        AND YEAR(dt_orcamento) = YEAR(NOW())
    ";
    $stmt = $pdo->query($query);
    $faturamentoMes = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
    
    // - Produtos em estoque (total de itens)
    $query = "SELECT COUNT(*) as total FROM produtos WHERE status = 'Ativo'";
    $stmt = $pdo->query($query);
    $produtosEstoque = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // - Produtos com estoque baixo (quantidade < 5)
    $query = "SELECT COUNT(*) as total FROM produtos WHERE quantidade < 5 AND status = 'Ativo'";
    $stmt = $pdo->query($query);
    $produtosBaixo = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // - Agendas/Compromissos de hoje
    $query = "
        SELECT COUNT(*) as total 
        FROM agenda 
        WHERE DATE(dt_agenda) = CURDATE()
    ";
    $stmt = $pdo->query($query);
    $compromissosHoje = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
    
    // - Crescimento de orçamentos (comparar com mês anterior)
    $query = "
        SELECT 
            (SELECT COUNT(*) FROM orcamentos WHERE MONTH(dt_orcamento) = MONTH(NOW()) AND YEAR(dt_orcamento) = YEAR(NOW())) as mes_atual,
            (SELECT COUNT(*) FROM orcamentos WHERE MONTH(dt_orcamento) = MONTH(DATE_SUB(NOW(), INTERVAL 1 MONTH)) AND YEAR(dt_orcamento) = YEAR(NOW())) as mes_anterior
    ";
    $stmt = $pdo->query($query);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $crescimentoOrc = $result['mes_anterior'] > 0 ? round((($result['mes_atual'] - $result['mes_anterior']) / $result['mes_anterior']) * 100) : 0;
    
    $data['kpis'] = [
        'orcamentos_ativos' => (int)$orcamentosAtivos,
        'crescimento_orc' => $crescimentoOrc,
        'faturamento_mes' => (float)$faturamentoMes,
        'produtos_estoque' => (int)$produtosEstoque,
        'produtos_baixo' => (int)$produtosBaixo,
        'compromissos_hoje' => (int)$compromissosHoje
    ];

    // 1. FATURAMENTO POR MÊS (últimos 6 meses)
    $query = "
        SELECT DATE_FORMAT(o.dt_orcamento, '%m') as mes, 
               SUM(o.vl_total) as total
        FROM orcamentos o
        WHERE o.dt_orcamento >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
        GROUP BY DATE_FORMAT(o.dt_orcamento, '%Y%m')
        ORDER BY o.dt_orcamento ASC
    ";
    $stmt = $pdo->query($query);
    $faturamento = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
    $vals = [];
    foreach ($faturamento as $item) {
        $vals[] = (float)$item['total'];
    }
    // Preencher meses faltantes com 0
    while (count($vals) < 6) {
        array_unshift($vals, 0);
    }
    $data['faturamento'] = [
        'meses' => array_slice($meses, -6),
        'vals' => array_slice($vals, -6)
    ];

    // 2. PEDRAS MAIS VENDIDAS
    $query = "
        SELECT p.nome_pedra as nome, 
               COUNT(op.id_pedra) as qtd,
               HEX(p.cor_hex) as cor
        FROM pedras p
        LEFT JOIN orcamento_pedra op ON p.id_pedra = op.id_pedra
        GROUP BY p.id_pedra
        ORDER BY qtd DESC
        LIMIT 3
    ";
    $stmt = $pdo->query($query);
    $pedras = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $pedrasFormatadas = [];
    $totalPedras = array_sum(array_column($pedras, 'qtd'));
    foreach ($pedras as $pedra) {
        $pct = $totalPedras > 0 ? round(($pedra['qtd'] / $totalPedras) * 100) : 0;
        $pedrasFormatadas[] = [
            'nome' => $pedra['nome'],
            'pct' => $pct,
            'cor' => '#' . $pedra['cor']
        ];
    }
    $data['pedras'] = $pedrasFormatadas;

    // 3. ORÇAMENTOS RECENTES
    $query = "
        SELECT o.id_orcamento, 
               c.nome_cliente as cliente,
               p.nome_pedra as pedra,
               o.vl_total as valor,
               o.st_orcamento as status
        FROM orcamentos o
        JOIN cliente c ON o.cd_cliente = c.cd_cliente
        JOIN orcamento_pedra op ON o.id_orcamento = op.id_orcamento
        JOIN pedras p ON op.id_pedra = p.id_pedra
        ORDER BY o.dt_orcamento DESC
        LIMIT 4
    ";
    $stmt = $pdo->query($query);
    $orcamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $orcamentosFormatados = [];
    foreach ($orcamentos as $orc) {
        $orcamentosFormatados[] = [
            'cliente' => $orc['cliente'],
            'pedra' => $orc['pedra'],
            'valor' => 'R$ ' . number_format($orc['valor'], 2, ',', '.'),
            'status' => $orc['status']
        ];
    }
    $data['orcamentos'] = $orcamentosFormatados;

    // 4. VENDEDORES (comissões)
    $query = "
        SELECT v.id_vendedor,
               v.nome_vendedor as nome,
               v.comissao,
               SUM(o.vl_total) as total_vendas
        FROM vendedor v
        LEFT JOIN orcamentos o ON v.id_vendedor = o.id_vendedor
        GROUP BY v.id_vendedor
        ORDER BY total_vendas DESC
        LIMIT 3
    ";
    $stmt = $pdo->query($query);
    $vendedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $vendedoresFormatados = [];
    foreach ($vendedores as $vend) {
        $comissao = ($vend['total_vendas'] * $vend['comissao']) / 100;
        $vendedoresFormatados[] = [
            'nome' => $vend['nome'],
            'comissao' => $vend['comissao'] . '%',
            'valor' => 'R$ ' . number_format($comissao, 2, ',', '.')
        ];
    }
    $data['vendedores'] = $vendedoresFormatados;

    echo json_encode($data, JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    echo json_encode(['erro' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
    http_response_code(500);
}
