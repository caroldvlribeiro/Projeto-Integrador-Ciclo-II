<?php
$paginaAtiva  = 'categorias';
$tituloPagina = 'Categorias - Marmoraria Nova Canaã';
$cssExtra     = '../assets/css/dashboard.css';
include './includes/usuario.php';
include './includes/Categorias.php';
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
        <h1 class="page-title">Categorias de Produto</h1>
        <p class="page-desc">Organize os produtos por tipo (insumos, ferramentas, acabamento...)</p>
    </div>
    <button class="btn btn-primary" onclick="abrirModalCriar()">＋ Nova categoria</button>
</div>

<div class="card">
    <?php if (empty($categorias)): ?>
        <div class="empty">
            <i class="ti ti-tag"></i>
            Nenhuma categoria cadastrada ainda.
        </div>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th style="width:60px;">ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th style="width:200px;text-align:right;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $cat): ?>
                    <tr>
                        <td class="col-id"><?= htmlspecialchars($cat['id_categoria']) ?></td>
                        <td><strong><?= htmlspecialchars($cat['nm_categoria']) ?></strong></td>
                        <td><?= htmlspecialchars($cat['ds_categoria']) ?></td>
                        <td>
                            <div class="actions">
                                <button class="btn btn-secondary btn-icon"
                                        onclick="abrirModalEditar(<?= $cat['id_categoria'] ?>, '<?= htmlspecialchars($cat['nm_categoria'], ENT_QUOTES) ?>', '<?= htmlspecialchars($cat['ds_categoria'], ENT_QUOTES) ?>')">
                                    ✎ Editar
                                </button>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Remover esta categoria?');">
                                    <input type="hidden" name="acao" value="deletar">
                                    <input type="hidden" name="id" value="<?= $cat['id_categoria'] ?>">
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

<!-- Modal Criar / Editar Categoria -->
<div class="modal-overlay" id="modal" onclick="if(event.target.id==='modal') fecharModal()">
    <div class="modal">
        <div class="modal-header">
            <h2 class="modal-title" id="modalTitulo">Nova Categoria</h2>
            <button class="modal-close" onclick="fecharModal()">×</button>
        </div>
        <form method="POST" id="formCategoria">
            <input type="hidden" name="acao" id="acao" value="criar">
            <input type="hidden" name="id" id="catId" value="">

            <div class="form-group">
                <label class="form-label" for="nome">Nome da categoria</label>
                <input class="form-input" type="text" id="nome" name="nome" required maxlength="50" placeholder="Ex: Insumos de acabamento">
            </div>

            <div class="form-group">
                <label class="form-label" for="descricao">Descrição</label>
                <textarea class="form-textarea" id="descricao" name="descricao" required placeholder="Para que serve essa categoria"></textarea>
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
        document.getElementById('modalTitulo').textContent = 'Nova Categoria';
        document.getElementById('acao').value = 'criar';
        document.getElementById('catId').value = '';
        document.getElementById('nome').value = '';
        document.getElementById('descricao').value = '';
        document.getElementById('modal').classList.add('open');
    }

    function abrirModalEditar(id, nome, descricao) {
        document.getElementById('modalTitulo').textContent = 'Editar Categoria';
        document.getElementById('acao').value = 'editar';
        document.getElementById('catId').value = id;
        document.getElementById('nome').value = nome;
        document.getElementById('descricao').value = descricao;
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