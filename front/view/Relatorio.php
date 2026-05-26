<?php
$paginaAtiva  = 'relatorio';
$tituloPagina = 'Relatório - Marmoraria Nova Canaã';
$cssExtra     = '../assets/css/relatorio.css';
include './includes/usuario.php';

if ($tipo !== 'Administrador') {
    header('Location: Dashboard.php');
    exit;
}

include './includes/layout.php';
?>

<div class="page-header">
    <div>
        <div class="page-eyebrow">Relatórios</div>
        <h1 class="page-title">Relatório Geral</h1>
        <p class="page-desc">Análise de orçamentos e vendas da marmoraria</p>
    </div>
    <button onclick="window.print()" class="btn btn-primary btn-pdf">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
            stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6,9 6,2 18,2 18,9"/>
            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
            <rect x="6" y="14" width="12" height="8"/>
        </svg>
        Gerar PDF
    </button>
</div>

<div class="card-filtros">
    <h2>Filtros</h2>
    <form method="GET" class="form-filtro">
        <div class="form-group">
            <label class="form-label">Data Inicial</label>
            <input class="form-input" type="date" name="inicio" value="<?= htmlspecialchars($_GET['inicio'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label class="form-label">Data Final</label>
            <input class="form-input" type="date" name="fim" value="<?= htmlspecialchars($_GET['fim'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label class="form-label">Status</label>
            <select class="form-input form-select" name="status">
                <option value="">Todos</option>
                <option value="Pendente"  <?= ($_GET['status'] ?? '') === 'Pendente'  ? 'selected' : '' ?>>Pendente</option>
                <option value="Aprovado"  <?= ($_GET['status'] ?? '') === 'Aprovado'  ? 'selected' : '' ?>>Aprovado</option>
                <option value="Finalizado"<?= ($_GET['status'] ?? '') === 'Finalizado'? 'selected' : '' ?>>Finalizado</option>
            </select>
        </div>
        <button type="submit" class="btn btn-accent btn-filtrar">Filtrar</button>
    </form>
</div>

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

<div class="card-table">
    <div class="table-header">
        <span class="table-title">Orçamentos</span>
        <span class="badge badge-finalizado">
            <?= count($relatorio) ?> resultado<?= count($relatorio) !== 1 ? 's' : '' ?>
        </span>
    </div>
    <div class="table-wrapper">
        <table class="table">
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
                            <div class="empty">
                                <i class="ti ti-circle-minus"></i>
                                Nenhum registro encontrado para os filtros selecionados.
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
                            <td class="td-data" data-label="Data Pedido"><?= date('d/m/Y', strtotime($item['dt_pedido'])) ?></td>
                            <td data-label="Venda"><?= $item['id_venda'] ?></td>
                            <td class="td-valor" data-label="Total">R$ <?= number_format($item['vl_total'], 2, ',', '.') ?></td>
                            <td data-label="Status">
                                <span class="badge <?= match($item['st_orcamento']) {
                                    'Aprovado'  => 'badge-aprovado',
                                    'Cancelado' => 'badge-cancelado',
                                    'Finalizado'=> 'badge-finalizado',
                                    default     => 'badge-aberto'
                                } ?>"><?= htmlspecialchars($item['st_orcamento']) ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</main>
</div>
</body>
</html>