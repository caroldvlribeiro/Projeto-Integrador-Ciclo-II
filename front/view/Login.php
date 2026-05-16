<?php
require_once __DIR__ . '/../../back/controller/AuthController.php';

if (session_status() === PHP_SESSION_NONE)
    session_start();

// Se já está logado, vai direto pro dashboard
if (isset($_SESSION['usuario'])) {
    header('Location: Dashboard.php');
    exit;
}

$auth = new AuthController();
$erro = '';

// Preenche o email com o cookie salvo (se "lembrar" foi marcado antes)
$emailSalvo = $_COOKIE['usuario_email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');
    $lembrar = isset($_POST['lembrar']);

    $resultado = $auth->login($email, $senha, $lembrar);

    if ($resultado['sucesso']) {
        header('Location: Dashboard.php');
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
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/login.css">
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <div class="login-logo">
                <svg width="40" height="40" viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg">
                    <rect x="2" y="2" width="52" height="52" fill="none" stroke="#EFF2F4" stroke-width="1.5" />
                    <rect x="12" y="12" width="52" height="52" fill="none" stroke="#EFF2F4" stroke-width="1.5" />
                    <rect x="22" y="22" width="52" height="52" fill="none" stroke="#EFF2F4" stroke-width="1.5" />
                    <rect x="46" y="46" width="14" height="14" fill="#EFF2F4" />
                </svg>
            </div>
            <h2>Login</h2>
        </div>

        <?php if ($erro): ?>
            <div class="error-message"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($emailSalvo) ?>" required>
            </div>

            <div class="form-group">
                <label>Senha</label>
                <div class="password-wrapper">
                    <input type="password" name="senha" id="senha" required>
                    <button type="button" class="btn-toggle-password" onclick="alternarSenha(this)">
                        <svg class="eye-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                            <line class="eye-slash" x1="3" y1="21" x2="21" y2="3"></line>
                        </svg>
                    </button>
                </div>
            </div>

            <label class="remember-me">
                <input type="checkbox" name="lembrar" <?= $emailSalvo ? 'checked' : '' ?>>
                <span>Lembrar-me</span>
            </label>

            <button type="submit">Entrar</button>
        </form>
    </div>

    <script>
        function alternarSenha(btn) {
            const input = document.getElementById('senha');
            if (input.type === 'password') {
                input.type = 'text';
                btn.classList.add('active');
            } else {
                input.type = 'password';
                btn.classList.remove('active');
            }
        }
    </script>
</body>

</html>