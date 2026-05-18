<?php
include './includes/usuario.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil — Marmoraria Nova Canaã</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Montserrat:wght@300;400;500;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/perfil.css">
</head>

<body>

    <!-- NAV igual ao Dashboard/Orcamentos -->
    <nav>
        <div class="nav-logo">
            <div class="isotipo">
                <svg width="40" height="40" viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg">
                    <rect x="2" y="2" width="52" height="52" fill="none" stroke="#EFF2F4" stroke-width="1.5" />
                    <rect x="12" y="12" width="52" height="52" fill="none" stroke="#EFF2F4" stroke-width="1.5" />
                    <rect x="22" y="22" width="52" height="52" fill="none" stroke="#EFF2F4" stroke-width="1.5" />
                    <rect x="46" y="46" width="14" height="14" fill="#EFF2F4" />
                </svg>
            </div>
            <div class="nav-brand">Nova Canaã<small>Marmoraria</small></div>
        </div>
        <ul class="nav-links">
            <li><a href="Dashboard.php">Home</a></li>
            <li><a href="Orcamentos.php">Orçamentos</a></li>
            <li><a href="Estoque.php">Estoque</a></li>
            <li>
                <a href="Perfil.php" class="nav-avatar-link active">
                    <svg width="32" height="32" viewBox="-44 -44 88 88" xmlns="http://www.w3.org/2000/svg">
                        <clipPath id="cp-dark">
                            <circle r="44" />
                        </clipPath>
                        <circle r="44" fill="#161F39" stroke="#AFC1F8" stroke-width="2" />
                        <circle cy="-6" r="16" fill="#5C93AA" />
                        <path d="M-28 38 Q-28 14 0 14 Q28 14 28 38" fill="#5C93AA" clip-path="url(#cp-dark)" />
                    </svg>
                    Perfil
                </a>
            </li>
        </ul>
    </nav>

    <main>

        <!-- Hero do perfil -->
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

        <!-- Tabela de vendas -->
        <div class="card-section">
            <div class="section-header"
                style="padding: var(--space-lg) var(--space-xl); border-bottom: 1px solid var(--color-border);">
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
                                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                            stroke="var(--color-border)" stroke-width="1.5">
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
                                    <td class="td-data" data-label="Data"><?= date('d/m/Y', strtotime($venda['dt_venda'])) ?>
                                    </td>
                                    <td class="td-valor" data-label="Valor">R$
                                        <?= number_format($venda['vl_total'], 2, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Logout -->
        <a href="Dashboard.php?acao=logout" class="logout-link"
            style="align-self:center; color:var(--color-error); text-decoration:none; font-size:var(--text-sm); font-weight:var(--font-medium); padding: var(--space-sm) var(--space-xl); border-radius:var(--radius-md); transition:background 0.2s;"
            onmouseover="this.style.background='#FCEBEB'" onmouseout="this.style.background='transparent'">
            🚪 Sair do Sistema
        </a>

    </main>
</body>

</html>