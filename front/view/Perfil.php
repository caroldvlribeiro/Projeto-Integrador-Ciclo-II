<?php
$paginaAtiva = 'perfil';
$tituloPagina = 'Perfil - Marmoraria Nova Canaã';
$cssExtra = '../assets/css/perfil.css';
include './includes/usuario.php';
include './includes/layout.php';
?>

<div class="perfil-hero">
    <div class="perfil-avatar">
        <svg viewBox="-44 -44 88 88" xmlns="http://www.w3.org/2000/svg">
            <clipPath id="cp-avatar">
                <circle r="44" />
            </clipPath>
            <circle r="44" fill="#0C3756" />
            <circle cy="-6" r="18" fill="#EFF2F4" />
            <path d="M-30 40 Q-30 16 0 16 Q30 16 30 40" fill="#EFF2F4" clip-path="url(#cp-avatar)" />
        </svg>
    </div>
    <div class="perfil-info">
        <h1>Meu Perfil</h1>
        <p class="perfil-email"><?= htmlspecialchars($logado['email_usuario']) ?></p>
        <span class="perfil-badge <?= $tipo === 'Administrador' ? 'admin' : 'vendedor' ?>">
            <?= htmlspecialchars($tipo) ?>
        </span>
    </div>
    <?php if ($tipo === 'Administrador'): ?>
        <div class="perfil-hero-actions">
            <a href="Relatorio.php" class="btn-relatorio">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <polyline points="14,2 14,8 20,8" />
                    <line x1="16" y1="13" x2="8" y2="13" />
                    <line x1="16" y1="17" x2="8" y2="17" />
                    <polyline points="10,9 9,9 8,9" />
                </svg>
                Gerar Relatório
            </a>
        </div>
    <?php endif; ?>
</div>

<div class="card-section">
    <div class="section-header"
        style="padding:var(--space-lg) var(--space-xl);border-bottom:1px solid var(--color-border);">
        <span class="section-title">Vendas Realizadas</span>
        <span class="section-count"><?= count($vendas) ?> registro<?= count($vendas) !== 1 ? 's' : '' ?></span>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Orçamento</th>
                    <th>Data da Venda</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($vendas)): ?>
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--color-border)"
                                    stroke-width="1.5">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="8" y1="12" x2="16" y2="12" />
                                </svg>
                                <p>Nenhuma venda registrada.</p>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($vendas as $venda): ?>
                        <tr>
                            <td class="td-id" data-label="ID"><?= $venda['id_venda'] ?></td>
                            <td data-label="Orçamento">#<?= $venda['id_orcamento'] ?></td>
                            <td class="td-data" data-label="Data"><?= date('d/m/Y', strtotime($venda['dt_venda'])) ?></td>
                            <td class="td-valor" data-label="Valor">R$ <?= number_format($venda['vl_total'], 2, ',', '.') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<a href="Perfil.php?acao=logout" class="logout-link"
    style="align-self:center;color:var(--color-error);text-decoration:none;font-size:var(--text-sm);font-weight:var(--font-medium);padding:var(--space-sm) var(--space-xl);border-radius:var(--radius-md);transition:background 0.2s;"
    onmouseover="this.style.background='#FCEBEB'" onmouseout="this.style.background='transparent'">
    🚪 Sair do Sistema
</a>

</main>
</div>
</body>

</html>