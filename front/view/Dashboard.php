<?php
require_once __DIR__ . '/../../back/controller/AuthController.php';

$auth = new AuthController();

// Logout mantém o cookie — email fica salvo no campo do login
if (isset($_GET['acao']) && $_GET['acao'] === 'logout') {
    $auth->logout();
}

// Bloqueia acesso sem sessão ativa
$auth->verificarSessao();

$logado = $_SESSION['usuario'];
$email = $logado['email_usuario'];
$tipo = $logado['tp_usuario']; // 'Administrador' ou 'Vendedor'
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - Marmoraria</title>
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>
    <nav>
        <div class="nav-logo">
            <div class="isotipo">
                <svg width="40" height="40" viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg">
                    <rect x="2" y="2" width="52" height="52" fill="none" stroke="#EFF2F4" stroke-width="1.5" />
                    <rect x="12" y="12" width="52" height="52" fill="none" stroke="#EFF2F4" stroke-width="1.5" />
                    <rect x="22" y="22" width="52" height="52" fill="none" stroke="#EFF2F4" stroke-width="1.5" />
                    <rect x="46" y="46" width="14" height="14" fill="#EFF2F4" />
                </svg>
            </div>
            <div class="nav-brand">Nova Canaã<small>Marmoraria</small></div>
        </div>
        <ul class="nav-links">
            <li><a class="active" href="Dashboard.php">Home</a></li>
            <li><a href="Orcamentos.php">Orçamentos</a></li>
            <li><a href="Categorias.php">Categorias</a></li>
            <li><a href="Produtos.php">Produtos</a></li>
            <li><a href="Estoque.php">Estoque</a></li>
            <li><a href="MovimentacoesEstoque.php">Movimentações</a></li>
            <li>
                <a href="Perfil.php" class="user-avatar" title="Meu Perfil" style="display:flex;text-decoration:none;">
                    <svg width="32" height="32" viewBox="-44 -44 88 88" xmlns="http://www.w3.org/2000/svg">
                        <clipPath id="cp-dark">
                            <circle r="44" />
                        </clipPath>
                        <circle r="44" fill="#161F39" stroke="#AFC1F8" stroke-width="2" />
                        <circle cy="-6" r="16" fill="#5C93AA" />
                        <path d="M-28 38 Q-28 14 0 14 Q28 14 28 38" fill="#5C93AA" clip-path="url(#cp-dark)" />
                    </svg>
                </a>
            </li>
        </ul>
    </nav>

    <main>
        <header class="dashboard-header">
            <div class="welcome-text">
                <h1>Painel de Controle</h1>
                <p>Bem-vindo, <?= htmlspecialchars($email) ?></p>
            </div>
        </header>

        <div class="dashboard-grid">
            <a href="Orcamentos.php" class="stat-card">
                <div class="stat-icon">📋</div>
                <div class="stat-content">
                    <h3>Orçamentos</h3>
                    <div class="value">Gerenciar</div>
                </div>
            </a>
            <a href="Categorias.php" class="stat-card">
                <div class="stat-icon">🏷️</div>
                <div class="stat-content">
                    <h3>Categorias</h3>
                    <div class="value">Organizar</div>
                </div>
            </a>
            <a href="Produtos.php" class="stat-card">
                <div class="stat-icon">🛍️</div>
                <div class="stat-content">
                    <h3>Produtos</h3>
                    <div class="value">Cadastrar</div>
                </div>
            </a>
            <a href="Estoque.php" class="stat-card">
                <div class="stat-icon">📦</div>
                <div class="stat-content">
                    <h3>Estoque</h3>
                    <div class="value">Consultar</div>
                </div>
            </a>
            <a href="MovimentacoesEstoque.php" class="stat-card">
                <div class="stat-icon">🔄</div>
                <div class="stat-content">
                    <h3>Movimentações</h3>
                    <div class="value">Registrar</div>
                </div>
            </a>
        </div>

        <div class="quick-actions">
            <a href="NovoOrcamento.php" class="btn-action">
                <i>+</i> Novo Orçamento
            </a>
        </div>

        <a href="Dashboard.php?acao=logout" class="logout-link">
            <span>🚪 Sair do Sistema</span>
        </a>
    </main>
</body>

</html>