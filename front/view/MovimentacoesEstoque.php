<?php
require_once __DIR__ . '/../../back/controller/AuthController.php';
require_once __DIR__ . '/../../back/config/database.php';
require_once __DIR__ . '/../../back/controller/MovimentacaoEstoqueController.php';

$controller = new MovimentacaoEstoqueController($pdo);
$mensagem = null;
$tipoMensagem = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    if ($acao === 'criar') {
        $id_produto = (int)($_POST['id_produto'] ?? 0);
        $tipo = trim($_POST['tipo'] ?? '');
        $quantidade = (int)($_POST['quantidade'] ?? 0);

        if ($controller->registrar($id_produto, $tipo, $quantidade)) {
            $mensagem = 'Movimentação registrada com sucesso.';
            $tipoMensagem = 'success';
        } else {
            $mensagem = $controller->getErro() ?? 'Erro ao registrar movimentação.';
            $tipoMensagem = 'error';
        }
    }
}

$movimentacoes = $controller->listar();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimentação de Estoque · Nova Canaã</title>
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
        <a href="../categoria_produto/index.php" class="nav-item">Categorias</a>
        <a href="../produto/index.php" class="nav-item">Produtos</a>
        <a href="../clientes/index.php" class="nav-item">Clientes</a>

        <div class="nav-label" style="margin-top:20px;">Operação</div>
        <a href="../estoque/index.php" class="nav-item">Estoque</a>
        <a href="index.php" class="nav-item active">Movimentação</a>
        <a href="../orcamento/index.php" class="nav-item">Orçamentos</a>
    </aside>

    <main class="main">

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
                <div class="empty">Nenhuma movimentação registrada ainda.</div>
            <?php else: ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width:60px;">ID</th>
                            <th>Produto</th>
                            <th>Antes</th>
                            <th>Operação</th>
                            <th>Qtd</th>
                            <th>Depois</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($movimentacoes as $mov): ?>
                            <tr>
                                <td class="col-id"><?= htmlspecialchars($mov['id_movimentacao']) ?></td>
                                <td><?= htmlspecialchars($mov['nm_produto'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($mov['qt_antes']) ?></td>
                                <td><?= htmlspecialchars($mov['tp_movimentacao']) ?></td>
                                <td><?= htmlspecialchars($mov['qt_movimentacao']) ?></td>
                                <td><?= htmlspecialchars($mov['qt_depois']) ?></td>
                                <td><?= htmlspecialchars($mov['dt_movimentacao']) ?></td>
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
            <h2 class="modal-title">Nova Movimentação</h2>
            <button class="modal-close" onclick="fecharModal()">×</button>
        </div>
        <form method="POST">
            <input type="hidden" name="acao" value="criar">

            <div class="form-group">
                <label class="form-label" for="id_produto">Produto</label>
                <input class="form-input" type="number" id="id_produto" name="id_produto" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="tipo">Tipo</label>
                <select class="form-input" id="tipo" name="tipo" required>
                    <option value="">Selecione...</option>
                    <option value="Entrada">Entrada</option>
                    <option value="Saída">Saída</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="quantidade">Quantidade</label>
                <input class="form-input" type="number" id="quantidade" name="quantidade" required min="1">
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

    document.getElementById('modal').addEventListener('click', (e) => {
        if (e.target.id === 'modal') fecharModal();
    });
</script>

</body>
</html>
