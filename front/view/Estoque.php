<?php
$paginaAtiva  = 'estoque';
$tituloPagina = 'Estoque - Marmoraria';
$cssExtra     = '../assets/css/dashboard.css';
include './includes/usuario.php';
include './includes/layout.php';
include './includes/Estoque.php';
?>

<div class="page-header">
    <div>
        <div class="page-eyebrow">Operação</div>
        <h1 class="page-title">Gestão de Estoque</h1>
        <p class="page-desc">Visualize os produtos em estoque e suas quantidades</p>
    </div>
</div>

<div class="card">
    <?php if (empty($estoques)): ?>
        <div class="empty">
            <i class="ti ti-stack"></i>
            Nenhum produto em estoque ainda.
        </div>
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
                        <td><strong><?= htmlspecialchars($item['nm_produto'] ?? 'N/A') ?></strong></td>
                        <td>
                            <?php $baixo = $item['qt_estoque'] < 5; ?>
                            <span <?= $baixo ? 'style="color:var(--color-error);font-weight:700;"' : '' ?>>
                                <?= htmlspecialchars($item['qt_estoque']) ?>
                                <?php if ($baixo): ?>
                                    <span class="badge badge-cancelado" style="margin-left:8px;">⚠ Baixo</span>
                                <?php endif; ?>
                            </span>
                        </td>
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