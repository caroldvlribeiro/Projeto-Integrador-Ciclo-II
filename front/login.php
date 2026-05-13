<?php
require_once __DIR__ . '/../back/controller/AuthController.php';

if (session_status() === PHP_SESSION_NONE)
    session_start();

// Se já está logado, vai direto pro dashboard
if (isset($_SESSION['usuario'])) {
    header('Location: dashboard.php');
    exit;
}

$auth = new AuthController();
$erro = '';

// Preenche o nome com o cookie salvo (se "lembrar" foi marcado antes)
$nomeSalvo = $_COOKIE['usuario_nome'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $senha = trim($_POST['senha'] ?? '');
    $lembrar = isset($_POST['lembrar']);

    $resultado = $auth->login($nome, $senha, $lembrar);

    if ($resultado['sucesso']) {
        header('Location: dashboard.php');
        exit;
    } else {
        $erro = $resultado['erro'];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login - Marmoraria</title>
</head>

<body>
    <h2>Login</h2>
    <?php if ($erro): ?>
        <p style="color:red"><?= htmlspecialchars($erro) ?></p>
    <?php endif; ?>
    <form method="POST">
        <label>Nome de usuário:
            <!-- value preenchido pelo cookie se "lembrar" estava marcado -->
            <input type="text" name="nome" value="<?= htmlspecialchars($nomeSalvo) ?>" required>
        </label><br>
        <label>Senha:
            <input type="password" name="senha" id="senha" required>
            <button type="button" onclick="alternarSenha()" >👁</button>
        </label><br>
        <label>
            <input type="checkbox" name="lembrar"> Lembrar-me
        </label><br>
        <button type="submit">Entrar</button>
    </form>
</body>

<script>
    function alternarSenha() {
        const input = document.getElementById('senha');
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>

</html>