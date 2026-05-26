<?php
$paginaAtiva = 'produtos';
$tituloPagina = 'Produtos - Marmoraria Nova Canaã';
$cssExtra = '../assets/css/dashboard.css';
include './includes/usuario.php';
include './includes/Produtos.php';
include './includes/layout.php';
?>

<?php if ($mensagem): ?>
    <div class="alert alert-<?= $tipoMensagem ?>">
        <?= htmlspecialchars($mensagem) ?>
    </div>
<?php endif; ?>

<div class="page-header">
    <div>
        <div class="page-eyebrow">Cadastros</div>
        <h1 class="page-title">Produtos</h1>
        <p class="page-desc">Gerencie os produtos do estoque</p>
    </div>
    <button class="btn btn-primary" onclick="abrirModalCriar()">＋ Novo produto</button>
</div>

<div class="card">
    <?php if (empty($produtos)): ?>
        <div class="empty">
            <i class="ti ti-package"></i>
            Nenhum produto cadastrado ainda.
        </div>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th style="width:60px;">ID</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Descrição</th>
                    <th style="width:120px;text-align:right;">Valor</th>
                    <th style="width:200px;text-align:right;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $prod): ?>
                    <tr>
                        <td class="col-id"><?= htmlspecialchars($prod['id_produto']) ?></td>
                        <td><strong><?= htmlspecialchars($prod['nm_produto']) ?></strong></td>
                        <td><?= htmlspecialchars($prod['nm_categoria'] ?? 'Sem categoria') ?></td>
                        <td><?= htmlspecialchars($prod['ds_produto']) ?></td>
                        <td style="text-align:right;">R$ <?= number_format((float) $prod['vl_produto'], 2, ',', '.') ?></td>
                        <td>
                            <div class="actions">
                                <button class="btn btn-ghost btn-icon" onclick="abrirModalEditar(
                                            <?= $prod['id_produto'] ?>,
                                            <?= $prod['id_categoria'] ?>,
                                            '<?= htmlspecialchars($prod['nm_produto'], ENT_QUOTES) ?>',
                                            '<?= htmlspecialchars($prod['ds_produto'], ENT_QUOTES) ?>',
                                            '<?= number_format((float) $prod['vl_produto'], 2, '.', '') ?>'
                                        )">
                                    ✎ Editar
                                </button>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Remover este produto?');">
                                    <input type="hidden" name="acao" value="deletar">
                                    <input type="hidden" name="id" value="<?= $prod['id_produto'] ?>">
                                    <button type="submit" class="btn btn-danger btn-icon">✕ Remover</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</main>
</div>

<!-- Modal Criar / Editar Produto -->
<div class="modal-overlay" id="modal" onclick="if(event.target.id==='modal') fecharModal()">
    <div class="modal">
        <div class="modal-header">
            <h2 class="modal-title" id="modalTitulo">Novo Produto</h2>
            <button class="modal-close" onclick="fecharModal()">×</button>
        </div>
        <form method="POST" id="formProduto">
            <input type="hidden" name="acao" id="acao" value="criar">
            <input type="hidden" name="id" id="prodId" value="">

            <div class="form-group">
                <label class="form-label" for="id_categoria">Categoria</label>
                <select class="form-input" id="id_categoria" name="id_categoria" required>
                    <option value="">Selecione uma categoria</option>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?= $cat['id_categoria'] ?>">
                            <?= htmlspecialchars($cat['nm_categoria']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="nome">Nome do produto</label>
                <input class="form-input" type="text" id="nome" name="nome" required maxlength="255"
                    placeholder="Ex: Disco de Corte Diamantado">
            </div>

            <div class="form-group">
                <label class="form-label" for="descricao">Descrição</label>
                <textarea class="form-textarea" id="descricao" name="descricao" required
                    placeholder="Descreva o produto"></textarea>
            </div>

            <div class="form-group">
                <label class="form-label" for="valor">Valor (R$)</label>
                <input class="form-input" type="number" id="valor" name="valor" required min="0" step="0.01"
                    placeholder="0,00">
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
        document.getElementById('modalTitulo').textContent = 'Novo Produto';
        document.getElementById('acao').value = 'criar';
        document.getElementById('prodId').value = '';
        document.getElementById('id_categoria').value = '';
        document.getElementById('nome').value = '';
        document.getElementById('descricao').value = '';
        document.getElementById('valor').value = '';
        document.getElementById('modal').classList.add('open');
    }

    function abrirModalEditar(id, idCat, nome, descricao, valor) {
        document.getElementById('modalTitulo').textContent = 'Editar Produto';
        document.getElementById('acao').value = 'editar';
        document.getElementById('prodId').value = id;
        document.getElementById('id_categoria').value = idCat;
        document.getElementById('nome').value = nome;
        document.getElementById('descricao').value = descricao;
        document.getElementById('valor').value = valor;
        document.getElementById('modal').classList.add('open');
    }

    function fecharModal() {
        document.getElementById('modal').classList.remove('open');
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') fecharModal();
    });
</script>

</body>

</html>