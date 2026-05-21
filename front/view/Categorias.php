<?php
require_once __DIR__ . '/../../back/controller/AuthController.php';
require_once __DIR__ . '/../../back/config/database.php';
require_once __DIR__ . '/../../back/controller/CategoriaProdutoController.php';

$controller = new CategoriaProdutoController($pdo);
$mensagem = null;
$tipoMensagem = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    if ($acao === 'criar') {
        $nome = trim($_POST['nome'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        if ($controller->salvar($nome, $descricao)) {
            $mensagem = 'Categoria cadastrada com sucesso.';
            $tipoMensagem = 'success';
        } else {
            $mensagem = 'Erro ao cadastrar: ' . ($controller->getErro() ?? 'verifique os dados.');
            $tipoMensagem = 'error';
        }
    } elseif ($acao === 'editar') {
        $id = (int)($_POST['id'] ?? 0);
        $nome = trim($_POST['nome'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        if ($controller->atualizar($id, $nome, $descricao)) {
            $mensagem = 'Categoria atualizada.';
            $tipoMensagem = 'success';
        } else {
            $mensagem = 'Erro ao atualizar: ' . ($controller->getErro() ?? 'verifique os dados.');
            $tipoMensagem = 'error';
        }
    } elseif ($acao === 'deletar') {
        $id = (int)($_POST['id'] ?? 0);
        if ($controller->deletar($id)) {
            $mensagem = 'Categoria removida.';
            $tipoMensagem = 'success';
        } else {
            $mensagem = 'Erro ao remover.';
            $tipoMensagem = 'error';
        }
    }
}

$categorias = $controller->listar();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias de Produto · Nova Canaã</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
<div class="app">

    <header class="header">
        <div class="logo">
            Nova Canaã
            <small>Marmoraria</small>
        </div>
        <div class="user">&#9679; Sistema Interno</div>
    </header>

    <aside class="sidebar">
        <div class="nav-label">Cadastros</div>
        <a href="index.php" class="nav-item active">Categorias</a>
        <a href="../produto/index.php" class="nav-item">Produtos</a>
        <a href="../clientes/index.php" class="nav-item">Clientes</a>

        <div class="nav-label" style="margin-top:20px;">Operação</div>
        <a href="../estoque/index.php" class="nav-item">Estoque</a>
        <a href="../movimentacao_estoque/index.php" class="nav-item">Movimentação</a>
        <a href="../orcamento/index.php" class="nav-item">Orçamentos</a>
    </aside>

    <main class="main">

        <div class="page-header">
            <div>
                <div class="page-eyebrow">Cadastros</div>
                <h1 class="page-title">Categorias de Produto</h1>
                <p class="page-desc">Organize os produtos por tipo (insumos, ferramentas, acabamento...)</p>
            </div>
            <button class="btn btn-primary" onclick="abrirModalCriar()">＋ Cadastrar nova categoria</button>
        </div>

        <?php if ($mensagem): ?>
            <div class="alert alert-<?= $tipoMensagem ?>">
                <?= htmlspecialchars($mensagem) ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <?php if (empty($categorias)): ?>
                <div class="empty">Nenhuma categoria cadastrada ainda. Clique em "Nova Categoria" para começar.</div>
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
                                        <form method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja remover esta categoria?');">
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

<div class="modal-overlay" id="modal">
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

    document.getElementById('modal').addEventListener('click', (e) => {
        if (e.target.id === 'modal') fecharModal();
    });
</script>

</body>
</html>
