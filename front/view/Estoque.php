<?php
require_once __DIR__ . '/../../back/controller/AuthController.php';
require_once __DIR__ . '/../../back/config/database.php';
require_once __DIR__ . '/../../back/controller/EstoqueController.php';

$controller = new EstoqueController($pdo);
$estoques = $controller->listar();

usort($estoques, function($a, $b) {
    return $a['id_estoque'] <=> $b['id_estoque'];
});
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque · Nova Canaã</title>
    <link rel="stylesheet" href="../assets/css/rubia.css">
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
        <a href="index.php" class="nav-item active">Estoque</a>
        <a href="../movimentacao_estoque/index.php" class="nav-item">Movimentação</a>
        <a href="../orcamento/index.php" class="nav-item">Orçamentos</a>
    </aside>

    <main class="main">

        <div class="page-header">
            <div>
                <div class="page-eyebrow">Operação</div>
                <h1 class="page-title">Gestão de Estoque</h1>
                <p class="page-desc">Visualize os produtos em estoque e suas quantidades</p>
            </div>
        </div>

        <div class="card">
            <?php if (empty($estoques)): ?>
                <div class="empty">Nenhum produto em estoque ainda.</div>
            <?php else: ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width:60px;">ID</th>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Última Atualização</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($estoques as $item): ?>
                            <tr>
                                <td class="col-id"><?= htmlspecialchars($item['id_estoque']) ?></td>
                                <td><?= htmlspecialchars($item['nm_produto'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($item['qt_estoque']) ?></td>
                                <td><?= htmlspecialchars($item['dt_atualizacao']) ?></td>
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
