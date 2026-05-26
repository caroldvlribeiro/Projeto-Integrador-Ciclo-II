<?php
$paginaAtiva  = 'movimentacoesestoque';
$tituloPagina = 'Movimentação Estoque - Marmoraria';
$cssExtra     = '../assets/css/dashboard.css';
include './includes/usuario.php';
include './includes/layout.php';
include './includes/MovimentacaoEstoque.php';
?>

<div class="page-header">
    <div>
        <div class="page-eyebrow">Operação</div>
        <h1 class="page-title">Movimentação de Estoque</h1>
        <p class="page-desc">Registre entradas e saídas de produtos</p>
    </div>
    <button class="btn btn-primary" onclick="abrirModalCriar()">＋ Nova movimentação</button>
</div>

<?php if ($mensagem): ?>
    <div class="alert alert-<?= $tipoMensagem ?>">
        <?= htmlspecialchars($mensagem) ?>
    </div>
<?php endif; ?>

<div class="card">
    <?php if (empty($movimentacoes)): ?>
        <div class="empty">
            <i class="ti ti-transfer"></i>
            Nenhuma movimentação registrada ainda.
        </div>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th style="width:60px;">ID</th>
                    <th>Produto</th>
                    <th>Operação</th>
                    <th>Qtd</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($movimentacoes as $mov): ?>
                    <tr>
                        <td class="col-id"><?= htmlspecialchars($mov['id_movimentacao']) ?></td>
                        <td><strong><?= htmlspecialchars($mov['nm_produto'] ?? 'N/A') ?></strong></td>
                        <td>
                            <span class="badge <?= $mov['tp_movimentacao'] === 'Entrada' ? 'badge-aprovado' : 'badge-cancelado' ?>">
                                <?= htmlspecialchars($mov['tp_movimentacao']) ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($mov['qt_movimentacao']) ?></td>
                        <td><?= htmlspecialchars($mov['dt_movimentacao']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</main>
</div>

<!-- Modal Nova Movimentação -->
<div class="modal-overlay" id="modal" onclick="if(event.target.id==='modal') fecharModal()">
    <div class="modal">
        <div class="modal-header">
            <h2 class="modal-title">Nova Movimentação</h2>
            <button class="modal-close" onclick="fecharModal()">×</button>
        </div>
        <form method="POST">
            <input type="hidden" name="acao" value="criar">

            <div class="form-group">
                <label class="form-label" for="id_produto">Produto</label>
                <select class="form-input form-select" id="id_produto" name="id_produto" required>
                    <option value="1">Disco de Corte Diamantado</option>
                    <option value="2">Disco de Polimento</option>
                    <option value="3">Resina Epóxi</option>
                    <option value="4">Cera para Polimento</option>
                    <option value="5">Silicone Incolor</option>
                    <option value="6">Parafuso e Bucha</option>
                    <option value="7">Lixa Diamantada</option>
                    <option value="8">Pasta de Polimento</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="tipo">Tipo</label>
                <select class="form-input form-select" id="tipo" name="tipo" required>
                    <option value="">Selecione...</option>
                    <option value="Entrada">Entrada</option>
                    <option value="Saída">Saída</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="quantidade">Quantidade</label>
                <input class="form-input" type="number" id="quantidade" name="quantidade"
                       required min="1" placeholder="Ex: 10">
            </div>

            <div class="modal-actions">
                <button type="button" class="btn btn-ghost" onclick="fecharModal()">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function abrirModalCriar() {
        document.getElementById('modal').classList.add('open');
    }
    function fecharModal() {
        document.getElementById('modal').classList.remove('open');
    }
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') fecharModal();
    });
</script>
</body>
</html>