<?php
$paginaAtiva = 'orcamentos';
$tituloPagina = 'Orçamentos - Marmoraria Nova Canaã';
$cssExtra = '../assets/css/orc.css';
include './includes/usuario.php';
include './includes/filtrosOrcamento.php';
include './includes/layout.php';
?>

<?php foreach ($orcamentos as $orc):
    $badgeClass = match($orc['st_orcamento']) {
        'Aberto'     => 'badge-aberto',
        'Aprovado'   => 'badge-aprovado',
        'Cancelado'  => 'badge-cancelado',
        'Finalizado' => 'badge-finalizado',
        default      => 'badge-aberto'
    };
?>
<div class="modal-overlay" id="ver-<?= $orc['id_orcamento'] ?>"
     onclick="if(event.target===this) this.classList.remove('open')">
    <div class="modal modal-detalhe">

        <!-- Cabeçalho -->
        <div class="md-header">
            <div class="md-header-left">
                <span class="md-header-eyebrow">Orçamento #<?= $orc['id_orcamento'] ?></span>
                <h2 class="md-header-title"><?= htmlspecialchars($orc['nm_cliente'] ?? '—') ?></h2>
            </div>
            <div class="md-header-right">
                <span class="badge <?= $badgeClass ?>"><?= $orc['st_orcamento'] ?></span>
                <button class="modal-close"
                    onclick="document.getElementById('ver-<?= $orc['id_orcamento'] ?>').classList.remove('open')">×</button>
            </div>
        </div>

        <!-- Strip de valor + metadados -->
        <div class="md-valor-strip">
            <div class="md-valor-principal">
                <span class="md-valor-label">Valor Total</span>
                <span class="md-valor-num">R$ <?= number_format($orc['vl_total'], 2, ',', '.') ?></span>
            </div>
            <div class="md-meta-row">
                <div class="md-meta-item">
                    <span class="md-meta-label">Pedido</span>
                    <span class="md-meta-val"><?= date('d/m/Y', strtotime($orc['dt_pedido'])) ?></span>
                </div>
                <div class="md-meta-item">
                    <span class="md-meta-label">Entrega</span>
                    <span class="md-meta-val"><?= date('d/m/Y', strtotime($orc['dt_entrega'])) ?></span>
                </div>
                <?php if (!empty($orc['nm_vendedor'])): ?>
                <div class="md-meta-item">
                    <span class="md-meta-label">Vendedor</span>
                    <span class="md-meta-val"><?= htmlspecialchars($orc['nm_vendedor']) ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Corpo -->
        <div class="md-body">

            <!-- Cliente -->
            <div>
                <div class="md-section-label">Cliente</div>
                <div class="md-fields">
                    <?php if (!empty($orc['cd_telefone'])): ?>
                    <div class="md-field">
                        <span class="md-field-label">Telefone</span>
                        <span class="md-field-val"><?= htmlspecialchars($orc['cd_telefone']) ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($orc['nm_endereco'])): ?>
                    <div class="md-field" style="grid-column: <?= empty($orc['cd_telefone']) ? 'auto' : 'auto' ?>">
                        <span class="md-field-label">Endereço</span>
                        <span class="md-field-val"><?= htmlspecialchars($orc['nm_endereco']) ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Material & Acabamento -->
            <div>
                <div class="md-section-label">Material &amp; Acabamento</div>
                <div class="md-fields">
                    <div class="md-field">
                        <span class="md-field-label">Acabamento</span>
                        <span class="md-field-val"><?= htmlspecialchars($orc['acabamento'] ?? '—') ?></span>
                    </div>
                    <div class="md-field">
                        <span class="md-field-label">Cuba</span>
                        <span class="md-field-val"><?= htmlspecialchars($orc['nm_cuba'] ?? '—') ?></span>
                    </div>
                    <div class="md-field">
                        <span class="md-field-label">Vista</span>
                        <span class="md-field-val"><?= htmlspecialchars($orc['vista'] ?? '—') ?></span>
                    </div>
                    <div class="md-field">
                        <span class="md-field-label">Saia</span>
                        <span class="md-field-val"><?= htmlspecialchars($orc['saia'] ?? '—') ?></span>
                    </div>
                </div>
                <?php if (!empty($orc['ds_descricao'])): ?>
                <div class="md-descricao">
                    <span class="md-field-label">Descrição</span>
                    <p class="md-descricao-txt"><?= nl2br(htmlspecialchars($orc['ds_descricao'])) ?></p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Pagamento -->
            <?php if (!empty($orc['vl_pagamento_entrada']) || !empty($orc['vl_pagamento_saida'])): ?>
            <div>
                <div class="md-section-label">Pagamento</div>
                <div class="md-pgto-grid">
                    <?php if (!empty($orc['vl_pagamento_entrada'])): ?>
                    <div class="md-pgto-card md-pgto-entrada">
                        <span class="md-pgto-tipo">Entrada</span>
                        <span class="md-pgto-valor">R$ <?= number_format($orc['vl_pagamento_entrada'], 2, ',', '.') ?></span>
                        <?php if (!empty($orc['dt_pagamento_entrada'])): ?>
                        <span class="md-pgto-data"><?= date('d/m/Y', strtotime($orc['dt_pagamento_entrada'])) ?></span>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($orc['vl_pagamento_saida'])): ?>
                    <div class="md-pgto-card md-pgto-saida">
                        <span class="md-pgto-tipo">Saída</span>
                        <span class="md-pgto-valor">R$ <?= number_format($orc['vl_pagamento_saida'], 2, ',', '.') ?></span>
                        <?php if (!empty($orc['dt_pagamento_saida'])): ?>
                        <span class="md-pgto-data"><?= date('d/m/Y', strtotime($orc['dt_pagamento_saida'])) ?></span>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

        </div>

        <!-- Rodapé -->
        <div class="modal-actions">
            <button type="button" class="btn btn-ghost"
                onclick="document.getElementById('ver-<?= $orc['id_orcamento'] ?>').classList.remove('open')">
                Fechar
            </button>
            <button type="button" class="btn btn-primary"
                onclick="
                    document.getElementById('ver-<?= $orc['id_orcamento'] ?>').classList.remove('open');
                    document.getElementById('editar-<?= $orc['id_orcamento'] ?>').classList.add('open');
                ">
                ✏ Editar
            </button>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- ========================================================
     MODAL DE EDIÇÃO
======================================================== -->
<?php foreach ($orcamentos as $orc): ?>
<div class="modal-overlay" id="editar-<?= $orc['id_orcamento'] ?>"
     onclick="if(event.target===this) this.classList.remove('open')">
    <div class="modal">
        <div class="modal-header">
            <h2 class="modal-title">Editar Orçamento #<?= $orc['id_orcamento'] ?></h2>
            <button class="modal-close"
                onclick="document.getElementById('editar-<?= $orc['id_orcamento'] ?>').classList.remove('open')">×</button>
        </div>
        <form method="POST" action="../../back/controller/OrcamentoController.php?acao=atualizar">
            <input type="hidden" name="idOrcamento" value="<?= $orc['id_orcamento'] ?>">
            <input type="hidden" name="cdCliente"   value="<?= $orc['cd_cliente'] ?>">

            <div class="form-group">
                <label class="form-label" for="valorTotal-<?= $orc['id_orcamento'] ?>">Valor Total</label>
                <input class="form-input" type="number" step="0.01" name="valorTotal"
                       id="valorTotal-<?= $orc['id_orcamento'] ?>"
                       value="<?= $orc['vl_total'] ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="status-<?= $orc['id_orcamento'] ?>">Status</label>
                <select class="form-input form-select" name="status" id="status-<?= $orc['id_orcamento'] ?>">
                    <option value="Aberto"    <?= $orc['st_orcamento'] === 'Aberto'    ? 'selected' : '' ?>>Aberto</option>
                    <option value="Aprovado"  <?= $orc['st_orcamento'] === 'Aprovado'  ? 'selected' : '' ?>>Aprovado</option>
                    <option value="Cancelado" <?= $orc['st_orcamento'] === 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
                    <option value="Finalizado"<?= $orc['st_orcamento'] === 'Finalizado'? 'selected' : '' ?>>Finalizado</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="dtSaida-<?= $orc['id_orcamento'] ?>">Data Pagamento Saída</label>
                <input class="form-input" type="date" name="dtPagamentoSaida"
                       id="dtSaida-<?= $orc['id_orcamento'] ?>"
                       value="<?= htmlspecialchars($orc['dt_pagamento_saida'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" for="valorSaida-<?= $orc['id_orcamento'] ?>">Valor Saída</label>
                <input class="form-input" type="number" step="0.01" name="valorSaida"
                       id="valorSaida-<?= $orc['id_orcamento'] ?>"
                       value="<?= htmlspecialchars($orc['vl_pagamento_saida'] ?? '') ?>">
            </div>

            <div class="modal-actions">
                <button type="button" class="btn btn-ghost"
                    onclick="document.getElementById('editar-<?= $orc['id_orcamento'] ?>').classList.remove('open')">
                    Cancelar
                </button>
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>
<?php endforeach; ?>

<!-- ========================================================
     BARRA DE AÇÕES
======================================================== -->
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
            <?php foreach ($orcamentos as $orc): ?>
                <tr class="row-clicavel"
                    style="cursor:pointer;"
                    onclick="document.getElementById('ver-<?= $orc['id_orcamento'] ?>').classList.add('open')"
                    title="Ver detalhes">
                    <td class="col-id"><?= $orc['id_orcamento'] ?></td>
                    <td><?= htmlspecialchars($orc['nm_cliente'] ?? '—') ?></td>
                    <td><?= date('d/m/Y', strtotime($orc['dt_pedido'])) ?></td>
                    <td><strong>R$ <?= number_format($orc['vl_total'], 2, ',', '.') ?></strong></td>
                    <td><?= date('d/m/Y', strtotime($orc['dt_entrega'])) ?></td>
                    <td>
                        <span class="badge <?= match($orc['st_orcamento']) {
                            'Aberto'    => 'badge-aberto',
                            'Aprovado'  => 'badge-aprovado',
                            'Cancelado' => 'badge-cancelado',
                            'Finalizado'=> 'badge-finalizado',
                            default     => 'badge-aberto'
                        } ?>"><?= $orc['st_orcamento'] ?></span>
                    </td>
                    <td onclick="event.stopPropagation()">
                        <div class="actions">
                            <a class="btn btn-danger btn-sm"
                               href="../../back/controller/OrcamentoController.php?acao=deletar&idOrcamento=<?= $orc['id_orcamento'] ?>&cdCliente=<?= $orc['cd_cliente'] ?>"
                               onclick="return confirm('Deseja deletar este orçamento?')">🗑 Deletar</a>
                            <button class="btn btn-secondary btn-sm"
                                onclick="document.getElementById('editar-<?= $orc['id_orcamento'] ?>').classList.add('open')">
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