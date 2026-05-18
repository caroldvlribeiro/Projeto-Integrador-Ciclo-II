<?php
require_once __DIR__ . '/../../back/config/database.php';

// Filtros
$filtro_cliente = $_GET['nm_cliente'] ?? '';
$filtro_data_inicio = $_GET['dt_inicio'] ?? date('Y-m-01'); // Primeiro dia do mês
$filtro_data_fim = $_GET['dt_fim'] ?? date('Y-m-d'); // Hoje

// Buscar orçamentos com filtros
$sql = "SELECT o.*, c.nm_cliente FROM orcamento o
        LEFT JOIN cliente c ON o.id_cliente = c.id_cliente WHERE 1=1";
$params = [];

if ($filtro_cliente) {
    $sql .= " AND c.nm_cliente LIKE ?";
    $params[] = "%{$filtro_cliente}%";
}
if ($filtro_data_inicio) {
    $sql .= " AND o.dt_pedido >= ?";
    $params[] = $filtro_data_inicio;
}
if ($filtro_data_fim) {
    $sql .= " AND o.dt_pedido <= ?";
    $params[] = $filtro_data_fim;
}

$sql .= " ORDER BY o.dt_pedido DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$orcamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calcular estatísticas
$total_orcamentos = count($orcamentos);
$valor_total = 0;
$valor_medio = 0;

foreach ($orcamentos as $orcamento) {
    $valor_total += $orcamento['vl_total'] ?? 0;
}
$valor_medio = $total_orcamentos > 0 ? $valor_total / $total_orcamentos : 0;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Orçamentos · Nova Canaã</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
<div class="app">

    <header class="header">
        <div class="logo">
            Nova Canaã
            <small>Marmoraria</small>
        </div>
        <div class="user">&#9679; Sistema Interno</div>
    </header>

    <aside class="sidebar">
        <div class="nav-label">Cadastros</div>
        <a href="../categoria_produto/index.php" class="nav-item">Categorias</a>
        <a href="../produto/index.php" class="nav-item">Produtos</a>
        <a href="../clientes/index.php" class="nav-item">Clientes</a>

        <div class="nav-label" style="margin-top:20px;">Operação</div>
        <a href="../estoque/index.php" class="nav-item">Estoque</a>
        <a href="../movimentacao_estoque/index.php" class="nav-item">Movimentação</a>
        <a href="index.php" class="nav-item active">Orçamentos</a>
    </aside>

    <main class="main">

        <div class="page-header">
            <div>
                <div class="page-eyebrow">Operação</div>
                <h1 class="page-title">Relatório de Orçamentos</h1>
                <p class="page-desc">Análise e acompanhamento de orçamentos no período</p>
            </div>
            <a href="index.php" class="btn btn-ghost">← Voltar</a>
        </div>

        <div class="card">
            <form method="GET" style="display:flex; gap:12px; margin-bottom:20px; flex-wrap:wrap; align-items:flex-end;">
                <div style="flex:1; min-width:150px;">
                    <label class="form-label" for="nm_cliente">Cliente</label>
                    <input class="form-input" type="text" id="nm_cliente" name="nm_cliente" value="<?= htmlspecialchars($filtro_cliente) ?>" placeholder="Nome do cliente">
                </div>
                <div style="flex:1; min-width:150px;">
                    <label class="form-label" for="dt_inicio">Data Início</label>
                    <input class="form-input" type="date" id="dt_inicio" name="dt_inicio" value="<?= htmlspecialchars($filtro_data_inicio) ?>">
                </div>
                <div style="flex:1; min-width:150px;">
                    <label class="form-label" for="dt_fim">Data Fim</label>
                    <input class="form-input" type="date" id="dt_fim" name="dt_fim" value="<?= htmlspecialchars($filtro_data_fim) ?>">
                </div>
                <button type="submit" class="btn btn-primary">🔍 Filtrar</button>
                <a href="relatorio.php" class="btn btn-ghost">Limpar</a>
            </form>

            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:12px; margin-bottom:20px;">
                <div style="background:#f5f5f5; padding:16px; border-radius:8px; border-left:4px solid #1976d2;">
                    <div style="font-size:12px; color:#666;">Total de Orçamentos</div>
                    <div style="font-size:24px; font-weight:bold; color:#1976d2;"><?= $total_orcamentos ?></div>
                </div>
                <div style="background:#f5f5f5; padding:16px; border-radius:8px; border-left:4px solid #388e3c;">
                    <div style="font-size:12px; color:#666;">Valor Total</div>
                    <div style="font-size:24px; font-weight:bold; color:#388e3c;">R$ <?= number_format($valor_total, 2, ',', '.') ?></div>
                </div>
                <div style="background:#f5f5f5; padding:16px; border-radius:8px; border-left:4px solid #f57c00;">
                    <div style="font-size:12px; color:#666;">Valor Médio</div>
                    <div style="font-size:24px; font-weight:bold; color:#f57c00;">R$ <?= number_format($valor_medio, 2, ',', '.') ?></div>
                </div>
            </div>

            <?php if (empty($orcamentos)): ?>
                <div class="empty">Nenhum orçamento encontrado no período.</div>
            <?php else: ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width:60px;">ID</th>
                            <th>Cliente</th>
                            <th>Data</th>
                            <th style="text-align:right;">Valor</th>
                            <th>Status</th>
                            <th>Descrição</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orcamentos as $orcamento): ?>
                            <tr>
                                <td class="col-id"><?= htmlspecialchars($orcamento['id_orcamento']) ?></td>
                                <td><?= htmlspecialchars($orcamento['nm_cliente'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($orcamento['dt_pedido'] ?? '') ?></td>
                                <td style="text-align:right;"><strong>R$ <?= number_format($orcamento['vl_total'] ?? 0, 2, ',', '.') ?></strong></td>
                                <td><span style="background:#e3f2fd; color:#1976d2; padding:4px 8px; border-radius:4px; font-size:12px;"><?= htmlspecialchars($orcamento['st_status'] ?? 'Aberto') ?></span></td>
                                <td><?= htmlspecialchars(substr($orcamento['ds_descricao'] ?? '', 0, 40)) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

    </main>
</div>

</body>
</html>
