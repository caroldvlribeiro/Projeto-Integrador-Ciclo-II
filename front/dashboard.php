<?php
require_once __DIR__ . '/../back/controller/AuthController.php';

$auth = new AuthController();

// Logout mantém o cookie — nome fica salvo no campo do login
if (isset($_GET['acao']) && $_GET['acao'] === 'logout') {
    $auth->logout();
}

// Bloqueia acesso sem sessão ativa
$auth->verificarSessao();

$logado = $_SESSION['usuario'];
$nome = $logado['nm_usuario'];
$tipo = $logado['tp_usuario']; // 'Administrador' ou 'Vendedor'
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>

<body>
    <h2>Bem-vindo, <?= htmlspecialchars($nome) ?>!</h2>
    <p>Tipo: <?= $tipo ?></p>
    <a href="dashboard.php?acao=logout">Sair</a>
</body>

</html>