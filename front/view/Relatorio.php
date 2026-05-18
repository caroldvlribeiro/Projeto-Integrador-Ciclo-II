<?php
include './includes/usuario.php';

if ($tipo !== 'Administrador') {
    header('Location: Dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório — Marmoraria Nova Canaã</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Montserrat:wght@300;400;500;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/relatorio.css">
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
                <a href="Perfil.php" class="nav-avatar-link">
                    <svg width="32" height="32" viewBox="-44 -44 88 88" xmlns="http://www.w3.org/2000/svg">
                        <clipPath id="cp-dark">
                            <circle r="44" />
                        </clipPath>
                        <circle r="44" fill="#161F39" stroke="#AFC1F8" stroke-width="2" />
                        <circle cy="-6" r="16" fill="#5C93AA" />
                        <path d="M-28 38 Q-28 14 0 14 Q28 14 28 38" fill="#5C93AA" clip-path="url(#cp-dark)" />
                    </svg>
                </a>
            </li>
        </ul>
    </nav>

    <main>

        <!-- Header da página -->
        <div class="page-header">
            <div>
                <h1>Relatório Geral</h1>
                <p>Análise de orçamentos e vendas da marmoraria</p>
            </div>
            <button onclick="window.print()" class="btn-pdf">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6,9 6,2 18,2 18,9" />
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                    <rect x="6" y="14" width="12" height="8" />
                </svg>
                Gerar PDF
            </button>
        </div>

        <!-- Filtros -->
        <div class="card-filtros">
            <h2>Filtros</h2>
            <form method="GET" class="form-filtro">
                <div class="form-group">
                    <label>Data Inicial</label>
                    <input type="date" name="inicio" value="<?= htmlspecialchars($_GET['inicio'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Data Final</label>
                    <input type="date" name="fim" value="<?= htmlspecialchars($_GET['fim'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="">Todos</option>
                        <option value="Pendente" <?= ($_GET['status'] ?? '') === 'Pendente' ? 'selected' : '' ?>>Pendente
                        </option>
                        <option value="Aprovado" <?= ($_GET['status'] ?? '') === 'Aprovado' ? 'selected' : '' ?>>Aprovado
                        </option>
                        <option value="Finalizado" <?= ($_GET['status'] ?? '') === 'Finalizado' ? 'selected' : '' ?>>
                            Finalizado</option>
                    </select>
                </div>
                <button type="submit" class="btn-filtrar">Filtrar</button>
            </form>
        </div>

        <!-- Cards de resumo -->
        <div class="summary-grid">
            <div class="summary-card">
                <h3>Total de Registros</h3>
                <div class="summary-value"><?= count($relatorio) ?></div>
            </div>
            <div class="summary-card">
                <h3>Total Vendido</h3>
                <div class="summary-value">R$ <?= number_format($totalVendas, 2, ',', '.') ?></div>
            </div>
        </div>

        <!-- Tabela de resultados -->
        <div class="card-table">
            <div class="table-header">
                <span class="table-title">Orçamentos</span>
                <span class="section-count"
                    style="font-size:var(--text-sm);color:var(--color-text-secondary);background:var(--color-bg-soft);padding:4px 12px;border-radius:20px;border:1px solid var(--color-border);">
                    <?= count($relatorio) ?> resultado<?= count($relatorio) !== 1 ? 's' : '' ?>
                </span>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Orçamento</th>
                            <th>Cliente</th>
                            <th>Telefone</th>
                            <th>Vendedor</th>
                            <th>Data Pedido</th>
                            <th>Venda</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($relatorio)): ?>
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                            stroke="var(--color-border)" stroke-width="1.5">
                                            <circle cx="12" cy="12" r="10" />
                                            <line x1="8" y1="12" x2="16" y2="12" />
                                        </svg>
                                        <p>Nenhum registro encontrado para os filtros selecionados.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($relatorio as $item): ?>
                                <tr>
                                    <td class="td-id" data-label="Orçamento">#<?= $item['id_orcamento'] ?></td>
                                    <td data-label="Cliente"><?= htmlspecialchars($item['nm_cliente']) ?></td>
                                    <td class="td-data" data-label="Telefone"><?= htmlspecialchars($item['cd_telefone']) ?></td>
                                    <td data-label="Vendedor"><?= htmlspecialchars($item['nm_vendedor']) ?></td>
                                    <td class="td-data" data-label="Data Pedido">
                                        <?= date('d/m/Y', strtotime($item['dt_pedido'])) ?></td>
                                    <td data-label="Venda"><?= $item['id_venda'] ?></td>
                                    <td class="td-valor" data-label="Total">R$
                                        <?= number_format($item['vl_total'], 2, ',', '.') ?></td>
                                    <td data-label="Status">
                                        <span class="badge-status <?= htmlspecialchars($item['st_orcamento']) ?>">
                                            <?= htmlspecialchars($item['st_orcamento']) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</body>

</html>