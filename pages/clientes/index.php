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
    <title>Clientes - Nova Canaã Marmoraria</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: #1a1a2e;
            color: #e0e0e0;
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* ============ HEADER ============ */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 70px;
            background: linear-gradient(90deg, #0f3460 0%, #1a1a2e 100%);
            border-bottom: 3px solid #ff6b35;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        }

        .header-logo {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .header-logo-title {
            font-family: 'Syne', sans-serif;
            font-size: 24px;
            font-weight: 700;
            color: #ff6b35;
        }

        .header-logo-subtitle {
            font-size: 11px;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header-status {
            font-size: 12px;
            color: #999;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background-color: #4ade80;
            border-radius: 50%;
            display: inline-block;
        }

        /* ============ SIDEBAR ============ */
        .sidebar {
            position: fixed;
            left: 0;
            top: 70px;
            width: 220px;
            height: calc(100vh - 70px);
            background-color: #0f3460;
            border-right: 1px solid #1a1a2e;
            padding: 30px 0;
            z-index: 999;
            overflow-y: auto;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .nav-item {
            display: block;
            padding: 14px 24px;
            color: #b0b0b0;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            position: relative;
            cursor: pointer;
        }

        .nav-item:hover {
            color: #ff6b35;
            background-color: rgba(255, 107, 53, 0.08);
            padding-left: 20px;
        }

        .nav-item.active {
            color: #ff6b35;
            background-color: rgba(255, 107, 53, 0.12);
            border-left-color: #ff6b35;
        }

        /* ============ MAIN CONTENT ============ */
        .main {
            margin-left: 220px;
            margin-top: 70px;
            padding: 40px;
            min-height: calc(100vh - 70px);
        }

        /* ============ PAGE HEADER ============ */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            gap: 20px;
        }

        .page-title-section h1 {
            font-family: 'Syne', sans-serif;
            font-size: 36px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 8px;
        }

        .page-title-section p {
            color: #999;
            font-size: 14px;
        }

        /* ============ BUTTONS ============ */
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-family: 'Nunito', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            white-space: nowrap;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c42 100%);
            color: #fff;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-small {
            padding: 8px 16px;
            font-size: 12px;
            background-color: #2a5f8f;
            color: #fff;
        }

        .btn-small:hover {
            background-color: #3a7faf;
            transform: translateY(-2px);
        }

        .btn-danger {
            padding: 8px 16px;
            font-size: 12px;
            background-color: #c0392b;
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #e74c3c;
            transform: translateY(-2px);
        }

        .btn-ghost {
            background-color: transparent;
            color: #e0e0e0;
            border: 1px solid #444;
        }

        .btn-ghost:hover {
            background-color: rgba(255, 107, 53, 0.1);
            color: #ff6b35;
            border-color: #ff6b35;
        }

        /* ============ ALERTS ============ */
        .alert {
            padding: 14px 18px;
            border-radius: 6px;
            margin-bottom: 20px;
            border-left: 3px solid;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background-color: rgba(76, 175, 80, 0.1);
            border-left-color: #4ade80;
            color: #4ade80;
        }

        .alert-error {
            background-color: rgba(192, 57, 43, 0.1);
            border-left-color: #ef4444;
            color: #ef4444;
        }

        .alert-info {
            background-color: rgba(66, 165, 245, 0.1);
            border-left-color: #42a5f5;
            color: #42a5f5;
        }

        /* ============ TABLE ============ */
        .table-container {
            background-color: #0f2438;
            border-radius: 8px;
            border: 1px solid #2a3a5a;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead {
            background-color: rgba(255, 107, 53, 0.12);
            border-bottom: 2px solid #ff6b35;
        }

        .data-table thead th {
            padding: 16px;
            text-align: left;
            color: #ff6b35;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .data-table tbody tr {
            border-bottom: 1px solid #2a3a5a;
            transition: background-color 0.2s ease;
        }

        .data-table tbody tr:hover {
            background-color: rgba(255, 107, 53, 0.05);
        }

        .data-table tbody tr:last-child {
            border-bottom: none;
        }

        .data-table td {
            padding: 16px;
            color: #e0e0e0;
        }

        .col-id {
            font-weight: 600;
            color: #ff6b35;
            width: 60px;
        }

        .col-name {
            font-weight: 500;
        }

        .col-phone {
            color: #b0b0b0;
            font-size: 13px;
        }

        .col-address {
            color: #999;
            font-size: 13px;
        }

        .col-actions {
            text-align: right;
        }

        .empty-state {
            padding: 60px 40px;
            text-align: center;
            color: #666;
        }

        .empty-state-icon {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .empty-state-title {
            font-size: 18px;
            font-weight: 600;
            color: #999;
            margin-bottom: 8px;
        }

        .empty-state-text {
            color: #666;
            font-size: 14px;
        }

        /* ============ MODAL ============ */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 2000;
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease;
        }

        .modal.active {
            display: flex;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .modal-content {
            background-color: #1a2d4d;
            border: 1px solid #2a3a5a;
            border-radius: 8px;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            padding: 24px;
            border-bottom: 2px solid #ff6b35;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            font-family: 'Syne', sans-serif;
            font-size: 22px;
            font-weight: 700;
            color: #fff;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            color: #999;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .modal-close:hover {
            color: #ff6b35;
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid #2a3a5a;
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        /* ============ FORM ============ */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #e0e0e0;
            font-size: 14px;
        }

        .form-input,
        .form-textarea {
            width: 100%;
            padding: 12px;
            background-color: rgba(0, 0, 0, 0.2);
            border: 1px solid #2a3a5a;
            border-radius: 6px;
            color: #e0e0e0;
            font-family: 'Nunito', sans-serif;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-input::placeholder,
        .form-textarea::placeholder {
            color: #666;
        }

        .form-input:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #ff6b35;
            background-color: rgba(0, 0, 0, 0.3);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
            font-family: 'Nunito', sans-serif;
        }

        /* ============ RESPONSIVIDADE ============ */
        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
                padding: 20px 0;
            }

            .nav-item {
                padding: 14px 10px;
                font-size: 0;
            }

            .nav-item::before {
                content: '▪';
                font-size: 12px;
                display: block;
            }

            .nav-item.active::before {
                content: '●';
            }

            .main {
                margin-left: 60px;
                padding: 30px 20px;
            }

            .page-header {
                flex-direction: column;
                gap: 16px;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .data-table thead th,
            .data-table td {
                padding: 12px 8px;
                font-size: 12px;
            }

            .header {
                padding: 0 20px;
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                display: none;
            }

            .main {
                margin-left: 0;
                padding: 20px;
            }

            .page-header {
                flex-direction: column;
            }

            .page-title-section h1 {
                font-size: 28px;
            }

            .header {
                padding: 0 16px;
            }

            .header-logo-title {
                font-size: 20px;
            }

            .data-table {
                font-size: 12px;
            }

            .data-table thead th,
            .data-table td {
                padding: 10px 6px;
            }

            .btn {
                padding: 10px 16px;
                font-size: 13px;
            }

            .modal-content {
                width: 95%;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-logo">
            <div class="header-logo-title">Nova Canaã</div>
            <div class="header-logo-subtitle">Marmoraria</div>
        </div>
        <div class="header-status">
            <span class="status-dot"></span>
            Sistema Interno
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <nav class="sidebar-nav">
            <a href="../categoria_produto/index.php" class="nav-item">Categorias</a>
            <a href="../produto/index.php" class="nav-item">Produtos</a>
            <a href="../estoque/index.php" class="nav-item">Estoque</a>
            <a href="../movimentacao_estoque/index.php" class="nav-item">Movimentação</a>
            <a href="../orcamento/index.php" class="nav-item">Orçamentos</a>
            <a href="../clientes/index.php" class="nav-item active">Clientes</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-title-section">
                <h1>Clientes</h1>
                <p>Gerencie seus clientes e informações de contato</p>
            </div>
            <button class="btn btn-primary" id="btnNovoCliente">
                <span>+</span> Novo Cliente
            </button>
        </div>

        <!-- Alerts -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['message_type'] ?? 'info' ?>">
                <?= htmlspecialchars($_SESSION['message']) ?>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
        <?php endif; ?>

        <!-- Table -->
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th class="col-id">ID</th>
                        <th class="col-name">Nome</th>
                        <th class="col-phone">Telefone</th>
                        <th class="col-address">Endereço</th>
                        <th class="col-actions">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($clientes) > 0): ?>
                        <?php foreach ($clientes as $cliente): ?>
                            <tr>
                                <td class="col-id"><?= htmlspecialchars($cliente['cd_cliente']) ?></td>
                                <td class="col-name"><?= htmlspecialchars($cliente['nm_cliente']) ?></td>
                                <td class="col-phone"><?= htmlspecialchars($cliente['cd_telefone']) ?></td>
                                <td class="col-address"><?= htmlspecialchars($cliente['nm_endereco']) ?></td>
                                <td class="col-actions">
                                    <button class="btn btn-small" onclick="abrirEditarCliente(<?= $cliente['cd_cliente'] ?>)">Editar</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <div class="empty-state-icon">📋</div>
                                    <div class="empty-state-title">Nenhum cliente cadastrado</div>
                                    <div class="empty-state-text">Clique em "Novo Cliente" para adicionar seu primeiro cliente</div>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Modal Novo Cliente -->
    <div class="modal" id="modalNovoCliente">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Novo Cliente</h2>
                <button class="modal-close" onclick="fecharModalNovoCliente()">×</button>
            </div>
            <form method="POST" action="novo_cliente.php">
                <div class="modal-body">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost" onclick="fecharModalNovoCliente()">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Criar Cliente</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Editar Cliente -->
    <div class="modal" id="modalEditarCliente">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Editar Cliente</h2>
                <button class="modal-close" onclick="fecharModalEditarCliente()">×</button>
            </div>
            <form method="POST" action="atualizar_cliente.php">
                <input type="hidden" id="edit_cd_cliente" name="cd_cliente">
                <div class="modal-body">
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
                </div>
                <div class="modal-footer">
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
            document.getElementById('modalNovoCliente').classList.add('active');
        }

        function fecharModalNovoCliente() {
            document.getElementById('modalNovoCliente').classList.remove('active');
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
                document.getElementById('modalEditarCliente').classList.add('active');
            }
        }

        function fecharModalEditarCliente() {
            document.getElementById('modalEditarCliente').classList.remove('active');
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
