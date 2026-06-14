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
  <title>Login - Marmoraria Nova Canaã</title>
  <link rel="stylesheet" href="../assets/css/base.css">
  <link rel="stylesheet" href="../assets/css/login.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
  <link rel="icon" type="image/x-icon" href="../assets/favicon.ico">
</head>
<body>

<div class="login-page">

  <div class="login-left">
    <svg class="marble-lines" viewBox="0 0 340 560" xmlns="http://www.w3.org/2000/svg">
      <path d="M0 90 Q80 65 160 105 Q240 140 340 95" stroke="#AFC1F8" stroke-width="1.5" fill="none"/>
      <path d="M0 200 Q90 175 170 210 Q255 242 340 195" stroke="#AFC1F8" stroke-width="1" fill="none"/>
      <path d="M0 310 Q100 285 180 318 Q265 348 340 300" stroke="#AFC1F8" stroke-width="0.8" fill="none"/>
      <path d="M0 420 Q85 395 165 428 Q250 458 340 415" stroke="#AFC1F8" stroke-width="1.2" fill="none"/>
      <path d="M85 0 Q100 140 80 280 Q65 390 95 560" stroke="#5C93AA" stroke-width="0.8" fill="none"/>
      <path d="M220 0 Q235 120 215 255 Q198 365 225 560" stroke="#5C93AA" stroke-width="0.6" fill="none"/>
    </svg>

    <div class="left-top">
      <svg width="36" height="36" viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg">
                <rect x="2"  y="2"  width="52" height="52" fill="none" stroke="#EFF2F4" stroke-width="1.5"/>
                <rect x="12" y="12" width="52" height="52" fill="none" stroke="#EFF2F4" stroke-width="1.5"/>
                <rect x="22" y="22" width="52" height="52" fill="none" stroke="#EFF2F4" stroke-width="1.5"/>
                <rect x="46" y="46" width="14" height="14" fill="#EFF2F4"/>
             </svg>
      <div class="brand-name">Nova Canaã</div>
      <div class="brand-sub">Marmoraria</div>
    </div>

    <div class="left-mid">
      <div class="quote-bar"></div>
      <div class="quote-text">Cada pedra conta<br>uma história de<br>precisão e beleza.</div>
    </div>

    <div class="left-bot">
      <div class="stone-pill">
        <div class="stone-dot" style="background:#2a2c2a;"></div>
        <span class="stone-label">Verde Ubatuba</span>
      </div>
      <div class="stone-pill">
        <div class="stone-dot" style="background:#ddd8d0;"></div>
        <span class="stone-label">Branco Itaúnas</span>
      </div>
    </div>
  </div>

  <div class="login-right">
    <h1 class="login-title">Bem-vindo<br>de volta</h1>
    <p class="login-desc">Acesse o sistema para gerenciar orçamentos, clientes e pedidos.</p>

    <?php if (!empty($erro)): ?>
      <div class="error-message"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="form-group">
        <label for="email">E-mail</label>
        <div class="field-wrap">
          <i class="ti ti-mail field-icon"></i>
          <input type="email" id="email" name="email"
                 value="<?= htmlspecialchars($emailSalvo) ?>"
                 placeholder="seu@email.com" required>
        </div>
      </div>

      <div class="form-group">
        <label for="senha">Senha</label>
        <div class="field-wrap">
          <i class="ti ti-lock field-icon"></i>
          <input type="password" id="senha" name="senha"
                 placeholder="••••••••" required>
          <button type="button" class="btn-toggle-password" onclick="alternarSenha(this)">
            <svg class="eye-icon" width="18" height="18" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
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

      <button type="submit">
        Entrar <i class="ti ti-arrow-right"></i>
      </button>
    </form>
  </div>

</div>

<script>
function alternarSenha(btn) {
  const input = document.getElementById('senha');
  input.type = input.type === 'password' ? 'text' : 'password';
  btn.classList.toggle('active');
}

document.getElementById('senha').addEventListener('keydown', e => {
  if (e.key === 'Enter') e.target.closest('form').submit();
});
</script>

</body>
</html>