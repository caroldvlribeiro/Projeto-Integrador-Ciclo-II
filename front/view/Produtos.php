<?php
$paginaAtiva = 'dprodutos';
$tituloPagina = 'Produtos - Marmoraria';
$cssExtra = '../assets/css/dashboard.css';
include './includes/usuario.php';
include './includes/layout.php';
include './includes/Produtos.php';


    if (isset($_GET['acao']) && $_GET['acao'] === 'logout') {
        session_destroy();

        header('Location: Login.php');
        exit;
    }
?>
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
