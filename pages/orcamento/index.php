<?php
session_start();
require_once __DIR__ . '/../../back/config/database.php';
require_once __DIR__ . '/../../back/controller/OrcamentoController.php';

$controller = new OrcamentoController();
$mensagem = $_SESSION['mensagem'] ?? null;
$tipo_mensagem = $_SESSION['tipo_mensagem'] ?? null;
unset($_SESSION['mensagem']);
unset($_SESSION['tipo_mensagem']);

// Filtros
$filtro_cliente = $_GET['nm_cliente'] ?? '';
$filtro_data_inicio = $_GET['dt_inicio'] ?? '';
$filtro_data_fim = $_GET['dt_fim'] ?? '';

// Buscar orçamentos
$sql = "SELECT o.*, c.nm_cliente FROM orcamento o
        LEFT JOIN cliente c ON o.cd_cliente = c.cd_cliente WHERE 1=1";
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
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orçamentos · Nova Canaã</title>
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
                <h1 class="page-title">Orçamentos</h1>
                <p class="page-desc">Gerencie e acompanhe os orçamentos de clientes</p>
            </div>
            <div>
                <a href="form.php" class="btn btn-primary">＋ Novo Orçamento</a>
                <a href="relatorio.php" class="btn btn-secondary" style="margin-left:8px;">📊 Relatório</a>
            </div>
        </div>

        <?php if ($mensagem): ?>
            <div class="alert alert-<?= htmlspecialchars($tipo_mensagem) ?>" style="margin-bottom:16px;">
                <?= htmlspecialchars($mensagem) ?>
            </div>
        <?php endif; ?>

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
                <a href="index.php" class="btn btn-ghost">Limpar</a>
            </form>

            <?php if (empty($orcamentos)): ?>
                <div class="empty">Nenhum orçamento encontrado. <a href="form.php">Crie um novo</a></div>
            <?php else: ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width:60px;">ID</th>
                            <th>Cliente</th>
                            <th>Data</th>
                            <th style="text-align:right;">Valor</th>
                            <th>Status</th>
                            <th style="width:140px;text-align:right;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orcamentos as $orcamento): ?>
                            <tr>
                                <td class="col-id"><?= htmlspecialchars($orcamento['id_orcamento']) ?></td>
                                <td><?= htmlspecialchars($orcamento['nm_cliente'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($orcamento['dt_pedido'] ?? '') ?></td>
                                <td style="text-align:right;"><strong>R$ <?= number_format($orcamento['vl_total'] ?? 0, 2, ',', '.') ?></strong></td>
                                <td><span style="background:#e3f2fd; color:#1976d2; padding:4px 8px; border-radius:4px; font-size:12px;"><?= htmlspecialchars($orcamento['st_orcamento'] ?? 'Aberto') ?></span></td>
                                <td style="text-align:right;">
                                    <a href="form.php?id=<?= $orcamento['id_orcamento'] ?>" class="btn btn-secondary btn-icon" style="padding:4px 8px; font-size:12px;">✎ Editar</a>
                                </td>
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
