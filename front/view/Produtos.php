<?php
require_once __DIR__ . '/../../back/controller/AuthController.php';
require_once __DIR__ . '/../../back/config/database.php';

$sql = "SELECT p.id_produto, p.nm_produto, p.ds_produto, c.nm_categoria
        FROM produto p
        LEFT JOIN categoria_produto c ON p.id_categoria = c.id_categoria
        ORDER BY p.id_produto ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos · Nova Canaã</title>
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
        <a href="index.php" class="nav-item active">Produtos</a>
        <a href="../clientes/index.php" class="nav-item">Clientes</a>

        <div class="nav-label" style="margin-top:20px;">Operação</div>
        <a href="../estoque/index.php" class="nav-item">Estoque</a>
        <a href="../movimentacao_estoque/index.php" class="nav-item">Movimentação</a>
        <a href="../orcamento/index.php" class="nav-item">Orçamentos</a>
    </aside>

    <main class="main">

        <div class="page-header">
            <div>
                <div class="page-eyebrow">Cadastros</div>
                <h1 class="page-title">Produtos</h1>
                <p class="page-desc">Gerencie os produtos do estoque</p>
            </div>
        </div>

        <div class="card">
            <?php if (empty($produtos)): ?>
                <div class="empty">Nenhum produto cadastrado ainda.</div>
            <?php else: ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width:60px;">ID</th>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th>Descrição</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produtos as $prod): ?>
                            <tr>
                                <td class="col-id"><?= htmlspecialchars($prod['id_produto']) ?></td>
                                <td><strong><?= htmlspecialchars($prod['nm_produto']) ?></strong></td>
                                <td><?= htmlspecialchars($prod['nm_categoria'] ?? 'Sem categoria') ?></td>
                                <td><?= htmlspecialchars($prod['ds_produto']) ?></td>
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
