<?php
$paginaAtiva = 'estoque';
$tituloPagina = 'Estoque - Marmoraria';
$cssExtra = '../assets/css/dashboard.css';
include './includes/usuario.php';
include './includes/layout.php';
include './includes/Estoque.php';


    if (isset($_GET['acao']) && $_GET['acao'] === 'logout') {
        session_destroy();

        header('Location: Login.php');
        exit;
    }
?>

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
