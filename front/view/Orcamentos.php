<?php
$paginaAtiva = 'orcamentos';
$tituloPagina = 'Orçamentos - Marmoraria Nova Canaã';
$cssExtra = '../assets/css/orc.css';
include './includes/usuario.php';
include './includes/filtrosOrcamento.php';
include './includes/layout.php';
?>

<!-- Modais de edição — padrão modal-overlay/modal do base.css -->
<?php foreach ($orcamentos as $orcamento): ?>
<div class="modal-overlay" id="editar-<?= $orcamento['id_orcamento'] ?>"
     onclick="if(event.target===this) this.classList.remove('open')">
    <div class="modal">
        <div class="modal-header">
            <h2 class="modal-title">Editar Orçamento #<?= $orcamento['id_orcamento'] ?></h2>
            <button class="modal-close"
                onclick="document.getElementById('editar-<?= $orcamento['id_orcamento'] ?>').classList.remove('open')">×</button>
        </div>
        <form method="POST" action="../../back/controller/OrcamentoController.php?acao=atualizar">
            <input type="hidden" name="idOrcamento" value="<?= $orcamento['id_orcamento'] ?>">
            <input type="hidden" name="cdCliente"   value="<?= $orcamento['cd_cliente'] ?>">

            <div class="form-group">
                <label class="form-label" for="valorTotal-<?= $orcamento['id_orcamento'] ?>">Valor Total</label>
                <input class="form-input" type="number" step="0.01" name="valorTotal"
                       id="valorTotal-<?= $orcamento['id_orcamento'] ?>"
                       value="<?= $orcamento['vl_total'] ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="status-<?= $orcamento['id_orcamento'] ?>">Status</label>
                <select class="form-input form-select" name="status" id="status-<?= $orcamento['id_orcamento'] ?>">
                    <option value="Aprovado"  <?= $orcamento['st_orcamento'] === 'Aprovado'  ? 'selected' : '' ?>>Aprovado</option>
                    <option value="Cancelado" <?= $orcamento['st_orcamento'] === 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
                    <option value="Finalizado"<?= $orcamento['st_orcamento'] === 'Finalizado'? 'selected' : '' ?>>Finalizado</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="dtSaida-<?= $orcamento['id_orcamento'] ?>">Data Pagamento Saída</label>
                <input class="form-input" type="date" name="dtPagamentoSaida"
                       id="dtSaida-<?= $orcamento['id_orcamento'] ?>">
            </div>

            <div class="form-group">
                <label class="form-label" for="valorSaida-<?= $orcamento['id_orcamento'] ?>">Valor Saída</label>
                <input class="form-input" type="number" step="0.01" name="valorSaida"
                       id="valorSaida-<?= $orcamento['id_orcamento'] ?>">
            </div>

            <div class="modal-actions">
                <button type="button" class="btn btn-ghost"
                    onclick="document.getElementById('editar-<?= $orcamento['id_orcamento'] ?>').classList.remove('open')">
                    Cancelar
                </button>
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>
<?php endforeach; ?>

<!-- Barra de ações -->
<div class="page-header">
    <div>
        <div class="page-eyebrow">Operação</div>
        <h1 class="page-title">Orçamentos</h1>
        <p class="page-desc">Gerencie todos os orçamentos da marmoraria</p>
    </div>
    <a href="NovoOrcamento.php" class="btn btn-primary">＋ Novo Orçamento</a>
</div>

<!-- Filtros -->
<div class="card" style="padding: 12px 16px;">
    <div style="display:flex; gap:12px; flex-wrap:wrap; align-items:center;">
        <form method="GET" id="clienteForm" style="display:flex; gap:8px; flex:1; min-width:200px;">
            <input class="form-input" style="flex:1;" type="text" name="busca"
                   placeholder="Buscar cliente..." value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>">
            <button type="submit" class="btn btn-primary btn-sm">Buscar</button>
        </form>
        <form method="GET" id="formPeriodo" style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
            <input class="form-input" type="date" name="dataInicio"
                   value="<?= htmlspecialchars($_GET['dataInicio'] ?? '') ?>" style="width:150px;">
            <input class="form-input" type="date" name="dataFim"
                   value="<?= htmlspecialchars($_GET['dataFim'] ?? '') ?>" style="width:150px;">
            <button type="submit" class="btn btn-accent btn-sm">Filtrar</button>
        </form>
    </div>
</div>

<!-- Tabela -->
<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th style="width:60px;">#ID</th>
                <th>Cliente</th>
                <th>Data do Orçamento</th>
                <th>Valor Total</th>
                <th>Data de Entrega</th>
                <th>Status</th>
                <th style="text-align:right;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orcamentos as $orcamento): ?>
                <tr>
                    <td class="col-id"><?= $orcamento['id_orcamento'] ?></td>
                    <td><?= htmlspecialchars($orcamento['nm_cliente'] ?? '—') ?></td>
                    <td><?= date('d/m/Y', strtotime($orcamento['dt_pedido'])) ?></td>
                    <td><strong>R$ <?= number_format($orcamento['vl_total'], 2, ',', '.') ?></strong></td>
                    <td><?= date('d/m/Y', strtotime($orcamento['dt_entrega'])) ?></td>
                    <td>
                        <span class="badge <?= match($orcamento['st_orcamento']) {
                            'Aberto'    => 'badge-aberto',
                            'Aprovado'  => 'badge-aprovado',
                            'Cancelado' => 'badge-cancelado',
                            'Finalizado'=> 'badge-finalizado',
                            default     => 'badge-aberto'
                        } ?>"><?= $orcamento['st_orcamento'] ?></span>
                    </td>
                    <td>
                        <div class="actions">
                            <a class="btn btn-danger btn-sm"
                               href="../../back/controller/OrcamentoController.php?acao=deletar&idOrcamento=<?= $orcamento['id_orcamento'] ?>&cdCliente=<?= $orcamento['cd_cliente'] ?>"
                               onclick="return confirm('Deseja deletar este orçamento?')">🗑 Deletar</a>
                            <button class="btn btn-secondary btn-sm"
                                onclick="document.getElementById('editar-<?= $orcamento['id_orcamento'] ?>').classList.add('open')">
                                ✏ Editar
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</main>
</div>
</body>
</html>