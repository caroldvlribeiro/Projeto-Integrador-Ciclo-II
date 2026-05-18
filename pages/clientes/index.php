<?php
session_start();
require_once '../../back/config/database.php';

// Get all clients
$stmt = $conn->prepare("SELECT cd_cliente, nm_cliente, cd_telefone, nm_endereco FROM cliente ORDER BY cd_cliente ASC");
$stmt->execute();
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes · Nova Canaã</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
<div class="app">

    <!-- Header -->
    <header class="header">
        <div class="logo">
            Nova Canaã
            <small>Marmoraria</small>
        </div>
        <div class="user">&#9679; Sistema Interno</div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="nav-label">Cadastros</div>
        <a href="../categoria_produto/index.php" class="nav-item">Categorias</a>
        <a href="../produto/index.php" class="nav-item">Produtos</a>
        <a href="../clientes/index.php" class="nav-item active">Clientes</a>

        <div class="nav-label" style="margin-top:20px;">Operação</div>
        <a href="../estoque/index.php" class="nav-item">Estoque</a>
        <a href="../movimentacao_estoque/index.php" class="nav-item">Movimentação</a>
        <a href="../orcamento/index.php" class="nav-item">Orçamentos</a>
    </aside>

    <!-- Main Content -->
    <main class="main">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <div class="page-eyebrow">Cadastros</div>
                <h1 class="page-title">Clientes</h1>
                <p class="page-desc">Gerencie os clientes e informações de contato</p>
            </div>
            <button class="btn btn-primary" id="btnNovoCliente">+ Novo Cliente</button>
        </div>

        <!-- Alerts -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['message_type'] ?? 'info' ?>">
                <?= htmlspecialchars($_SESSION['message']) ?>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
        <?php endif; ?>

        <!-- Table Card -->
        <div class="card">
            <?php if (empty($clientes)): ?>
                <div class="empty">Nenhum cliente cadastrado ainda.</div>
            <?php else: ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width:80px;">ID</th>
                            <th>Nome</th>
                            <th style="width:180px;">Telefone</th>
                            <th>Endereço</th>
                            <th style="width:120px;text-align:right;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clientes as $cliente): ?>
                            <tr>
                                <td class="col-id"><?= htmlspecialchars($cliente['cd_cliente']) ?></td>
                                <td><strong><?= htmlspecialchars($cliente['nm_cliente']) ?></strong></td>
                                <td><?= htmlspecialchars($cliente['cd_telefone']) ?></td>
                                <td><?= htmlspecialchars($cliente['nm_endereco']) ?></td>
                                <td>
                                    <div class="actions" style="justify-content:flex-end;">
                                        <button class="btn btn-icon" onclick="abrirEditarCliente(<?= $cliente['cd_cliente'] ?>)">Editar</button>
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

<!-- Modal Novo Cliente -->
<div class="modal-overlay" id="modalNovoCliente">
    <div class="modal">
        <div class="modal-header">
            <h2 class="modal-title">Novo Cliente</h2>
            <button class="modal-close" onclick="fecharModalNovoCliente()">×</button>
        </div>
        <form method="POST" action="novo_cliente.php">
            <div class="form-group">
                <label class="form-label" for="nm_cliente">Nome *</label>
                <input type="text" class="form-input" id="nm_cliente" name="nm_cliente" required placeholder="Digite o nome do cliente">
            </div>
            <div class="form-group">
                <label class="form-label" for="cd_telefone">Telefone</label>
                <input type="tel" class="form-input" id="cd_telefone" name="cd_telefone" placeholder="(00) 00000-0000">
            </div>
            <div class="form-group">
                <label class="form-label" for="nm_endereco">Endereço</label>
                <textarea class="form-textarea" id="nm_endereco" name="nm_endereco" placeholder="Rua, número, complemento..."></textarea>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-ghost" onclick="fecharModalNovoCliente()">Cancelar</button>
                <button type="submit" class="btn btn-primary">Criar Cliente</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar Cliente -->
<div class="modal-overlay" id="modalEditarCliente">
    <div class="modal">
        <div class="modal-header">
            <h2 class="modal-title">Editar Cliente</h2>
            <button class="modal-close" onclick="fecharModalEditarCliente()">×</button>
        </div>
        <form method="POST" action="atualizar_cliente.php">
            <input type="hidden" id="edit_cd_cliente" name="cd_cliente">
            <div class="form-group">
                <label class="form-label" for="edit_nm_cliente">Nome *</label>
                <input type="text" class="form-input" id="edit_nm_cliente" name="nm_cliente" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="edit_cd_telefone">Telefone</label>
                <input type="tel" class="form-input" id="edit_cd_telefone" name="cd_telefone">
            </div>
            <div class="form-group">
                <label class="form-label" for="edit_nm_endereco">Endereço</label>
                <textarea class="form-textarea" id="edit_nm_endereco" name="nm_endereco"></textarea>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-danger" onclick="confirmarDelecao()">Deletar</button>
                <button type="button" class="btn btn-ghost" onclick="fecharModalEditarCliente()">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Dados dos clientes para edição
    const clientesData = <?= json_encode($clientes) ?>;

    // Novo Cliente
    document.getElementById('btnNovoCliente').addEventListener('click', abrirModalNovoCliente);

    function abrirModalNovoCliente() {
        document.getElementById('modalNovoCliente').classList.add('open');
    }

    function fecharModalNovoCliente() {
        document.getElementById('modalNovoCliente').classList.remove('open');
        document.getElementById('modalNovoCliente').querySelector('form').reset();
    }

    // Fechar modal ao clicar fora
    document.getElementById('modalNovoCliente').addEventListener('click', function(e) {
        if (e.target === this) fecharModalNovoCliente();
    });

    // Editar Cliente
    function abrirEditarCliente(id) {
        const cliente = clientesData.find(c => parseInt(c.cd_cliente) === parseInt(id));
        if (cliente) {
            document.getElementById('edit_cd_cliente').value = cliente.cd_cliente;
            document.getElementById('edit_nm_cliente').value = cliente.nm_cliente;
            document.getElementById('edit_cd_telefone').value = cliente.cd_telefone;
            document.getElementById('edit_nm_endereco').value = cliente.nm_endereco;
            document.getElementById('modalEditarCliente').classList.add('open');
        }
    }

    function fecharModalEditarCliente() {
        document.getElementById('modalEditarCliente').classList.remove('open');
    }

    // Fechar modal ao clicar fora
    document.getElementById('modalEditarCliente').addEventListener('click', function(e) {
        if (e.target === this) fecharModalEditarCliente();
    });

    // Confirmar Deleção
    function confirmarDelecao() {
        const clienteId = document.getElementById('edit_cd_cliente').value;
        if (confirm('Tem certeza que deseja deletar este cliente?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'deletar_cliente.php';
            form.innerHTML = '<input type="hidden" name="cd_cliente" value="' + clienteId + '">';
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Fechar modal ao pressionar ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            fecharModalNovoCliente();
            fecharModalEditarCliente();
        }
    });
</script>

</body>
</html>
