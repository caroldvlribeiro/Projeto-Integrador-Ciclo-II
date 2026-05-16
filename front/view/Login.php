<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../assets/css/base.css">
  <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
<div class="login-page">
  <div class="login-left">
    <svg class="marble-lines" viewBox="0 0 340 520" xmlns="http://www.w3.org/2000/svg">
      <path d="M0 90 Q80 65 160 105 Q240 140 340 95" stroke="#AFC1F8" stroke-width="1.5" fill="none"/>
      <path d="M0 190 Q90 165 170 205 Q255 240 340 190" stroke="#AFC1F8" stroke-width="1" fill="none"/>
      <path d="M20 290 Q100 268 180 305 Q265 338 340 288" stroke="#AFC1F8" stroke-width="0.8" fill="none"/>
      <path d="M0 390 Q85 368 165 402 Q250 432 340 388" stroke="#AFC1F8" stroke-width="1.2" fill="none"/>
      <path d="M85 0 Q100 130 80 260 Q65 370 95 520" stroke="#5C93AA" stroke-width="0.8" fill="none"/>
      <path d="M210 0 Q225 115 205 245 Q188 350 215 520" stroke="#5C93AA" stroke-width="0.6" fill="none"/>
    </svg>

    <div class="left-top">
      <div class="isotipo">
        <svg width="80" height="80" viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg">
          <rect x="2" y="2" width="52" height="52" fill="none" stroke="#EFF2F4" stroke-width="1.5"/>
          <rect x="12" y="12" width="52" height="52" fill="none" stroke="#EFF2F4" stroke-width="1.5"/>
          <rect x="22" y="22" width="52" height="52" fill="none" stroke="#EFF2F4" stroke-width="1.5"/>
          <rect x="46" y="46" width="14" height="14" fill="#EFF2F4"/>
        </svg>
      </div>
      <div class="brand-name">Nova Canaã</div>
      <div class="brand-sub">Marmoraria</div>
    </div>

    <div class="left-middle">
      <div class="quote-bar"></div>
      <div class="quote-text">Cada pedra conta<br>uma história de<br>precisão e beleza.</div>
    </div>

    <div class="left-bottom">
      <div class="stone-pill">
        <div class="stone-dot" style="background:#e0dbd5;"></div>
        <span class="stone-label">Branco Dallas</span>
      </div>
      <div class="stone-pill">
        <div class="stone-dot" style="background:#2a1f18;"></div>
        <span class="stone-label">Ubatuba</span>
      </div>
    </div>
  </div>

  <div class="login-right">
    <div class="login-eyebrow">Área restrita</div>
    <h1 class="login-title">Bem-vindo<br>de volta</h1>
    <p class="login-desc">Acesse o sistema para gerenciar orçamentos, clientes e pedidos.</p>
    <form action="#" method="post">
      <div class="field-group">
        <label class="field-label" for="usuario">Usuário</label>
        <div class="field-wrap">
          <i class="ti ti-user field-icon" aria-hidden="true"></i>
          <input class="login-input" id="usuario" type="text" placeholder="seu.usuario" name="user">
        </div>
      </div>

      <div class="field-group">
        <label class="field-label" for="senha">Senha</label>
        <div class="field-wrap">
          <i class="ti ti-lock field-icon" aria-hidden="true"></i>
          <input class="login-input" id="senha" type="password" placeholder="••••••••" name="password">
          <button class="toggle-pass" id="toggleBtn" type="button" aria-label="Mostrar senha">
            <i class="ti ti-eye" id="eyeIcon" aria-hidden="true"></i>
          </button>
        </div>
      </div>

     

      <button class="btn-primary" id="btnEntrar" type="submit">
        Entrar
        <i class="ti ti-arrow-right" aria-hidden="true"></i>
      </button>
    </form>

    <div id="statusMsg" class="status-msg"></div>
  </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

<script>
const toggleBtn = document.getElementById('toggleBtn');
const senhaInput = document.getElementById('senha');
const eyeIcon = document.getElementById('eyeIcon');

toggleBtn.addEventListener('click', () => {
  const isPass = senhaInput.type === 'password';
  senhaInput.type = isPass ? 'text' : 'password';
  eyeIcon.className = isPass ? 'ti ti-eye-off' : 'ti ti-eye';
});

document.getElementById('btnEntrar').addEventListener('click', () => {
  const u = document.getElementById('usuario').value.trim();
  const s = document.getElementById('senha').value.trim();
  const msg = document.getElementById('statusMsg');
  msg.className = 'status-msg';
  if (!u || !s) {
    msg.className = 'status-msg error';
    msg.textContent = 'Preencha usuário e senha para continuar.';
    return;
  }
  if (u === 'admin' && s === '1234') {
    msg.className = 'status-msg success';
    msg.textContent = 'Acesso autorizado. Redirecionando...';
  } else {
    msg.className = 'status-msg error';
    msg.textContent = 'Usuário ou senha inválidos. Tente novamente.';
  }
});

document.getElementById('senha').addEventListener('keydown', e => {
  if (e.key === 'Enter') document.getElementById('btnEntrar').click();
});
</script>
</body>
</html>