<?php
$paginaAtiva = 'perfil';
$tituloPagina = 'Perfil - Marmoraria Nova Canaã';
$cssExtra = '../assets/css/perfil.css';
include './includes/usuario.php'; // sessão, POSTs e dados
include './includes/layout.php';  // abre html, header, sidebar e <main>
?>

<!-- ── Feedback global ───────────────────────────────────── -->
<?php if ($feedbackMsg): ?>
    <div class="perfil-feedback perfil-feedback--<?= $feedbackTipo ?>">
        <?php if ($feedbackTipo === 'sucesso'): ?>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12" />
            </svg>
        <?php else: ?>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" y1="8" x2="12" y2="12" />
                <line x1="12" y1="16" x2="12.01" y2="16" />
            </svg>
        <?php endif; ?>
        <?= htmlspecialchars($feedbackMsg) ?>
    </div>
<?php endif; ?>

<!-- ── Hero ──────────────────────────────────────────────── -->
<div class="perfil-hero">
    <div class="perfil-avatar">
        <svg viewBox="-44 -44 88 88" xmlns="http://www.w3.org/2000/svg">
            <clipPath id="cp-avatar">
                <circle r="44" />
            </clipPath>
            <circle r="44" fill="#0C3756" />
            <circle cy="-6" r="18" fill="#EFF2F4" />
            <path d="M-30 40 Q-30 16 0 16 Q30 16 30 40" fill="#EFF2F4" clip-path="url(#cp-avatar)" />
        </svg>
    </div>

    <div class="perfil-info">
        <h1>Meu Perfil</h1>
        <p class="perfil-email"><?= htmlspecialchars($logado['email_usuario']) ?></p>
        <!-- classe 'admin' ou 'vendedor' muda a cor do badge -->
        <span class="perfil-badge <?= $tipo === 'Administrador' ? 'admin' : 'vendedor' ?>">
            <?= htmlspecialchars($tipo) ?>
        </span>
    </div>

    <div class="perfil-hero-actions"
        style="display:flex;flex-direction:column;gap:var(--space-sm);align-items:flex-end;">
        <button class="btn-editar" onclick="abrirModal('modal-email')">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
            </svg>
            Alterar E-mail
        </button>
        <button class="btn-editar" onclick="abrirModal('modal-senha')">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
            </svg>
            Alterar Senha
        </button>

        <?php if ($tipo === 'Administrador'): // botão exclusivo para admin ?>
            <a href="Relatorio.php" class="btn-relatorio" style="margin-top:var(--space-xs);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <polyline points="14,2 14,8 20,8" />
                    <line x1="16" y1="13" x2="8" y2="13" />
                    <line x1="16" y1="17" x2="8" y2="17" />
                    <polyline points="10,9 9,9 8,9" />
                </svg>
                Gerar Relatório
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- ── Card de informações do usuário / vendedor ─────────── -->
<div class="card-section">
    <div class="section-header"
        style="padding:var(--space-lg) var(--space-xl);border-bottom:1px solid var(--color-border);">
        <span class="section-title">Informações da Conta</span>
    </div>
    <div class="perfil-info-grid">

        <?php
        // Exibe nome e comissão se o usuário tiver linha na tabela 'vendedor'.
        // $dadosVendedor é null quando não há vínculo (ex: administrador sem cadastro de vendedor).
        if ($dadosVendedor):
            ?>
            <!-- Nome e comissão vindos da tabela 'vendedor' (vinculada via id_usuario) -->
            <div class="perfil-info-item">
                <span class="perfil-info-label">Nome do Vendedor</span>
                <span class="perfil-info-value"><?= htmlspecialchars($dadosVendedor['nm_vendedor']) ?></span>
            </div>
            <div class="perfil-info-item">
                <span class="perfil-info-label">Comissão</span>
                <span class="perfil-info-value"><?= number_format($dadosVendedor['vl_comissao'], 2, ',', '.') ?>%</span>
            </div>
        <?php else: ?>
            <div class="perfil-info-item">
                <span class="perfil-info-label">Vínculo com Vendedor</span>
                <span class="perfil-info-value" style="color:var(--color-text-secondary);font-style:italic;">Nenhum cadastro
                    de vendedor vinculado</span>
            </div>
        <?php endif; ?>

    </div>
</div>

<!-- ── Vendas realizadas ──────────────────────────────────── -->
<div class="card-section">
    <div class="section-header"
        style="padding:var(--space-lg) var(--space-xl);border-bottom:1px solid var(--color-border);">
        <span class="section-title">Vendas Realizadas</span>
        <span class="section-count">
            <?= count($vendas) ?> registro<?= count($vendas) !== 1 ? 's' : '' ?>
        </span>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Orçamento</th>
                    <th>Data da Venda</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($vendas)): ?>
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--color-border)"
                                    stroke-width="1.5">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="8" y1="12" x2="16" y2="12" />
                                </svg>
                                <p>Nenhuma venda registrada.</p>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($vendas as $venda): ?>
                        <tr>
                            <td class="td-id" data-label="ID"><?= $venda['id_venda'] ?></td>
                            <td data-label="Orçamento">#<?= $venda['id_orcamento'] ?></td>
                            <td class="td-data" data-label="Data"><?= date('d/m/Y', strtotime($venda['dt_venda'])) ?></td>
                            <td class="td-valor" data-label="Valor">R$ <?= number_format($venda['vl_total'], 2, ',', '.') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<a href="Perfil.php?acao=logout" class="logout-link"
    style="align-self:center;color:var(--color-error);text-decoration:none;font-size:var(--text-sm);font-weight:var(--font-medium);padding:var(--space-sm) var(--space-xl);border-radius:var(--radius-md);transition:background 0.2s;"
    onmouseover="this.style.background='#FCEBEB'" onmouseout="this.style.background='transparent'">
    🚪 Sair do Sistema
</a>

</main>
</div>

<!-- ══════════════════════════════════════════════════════════
     MODAL — Alterar E-mail
══════════════════════════════════════════════════════════ -->
<div id="modal-email" class="perfil-modal-overlay" onclick="fecharModalFora(event, 'modal-email')">
    <div class="perfil-modal">
        <div class="perfil-modal-header">
            <h2>Alterar E-mail</h2>
            <button class="perfil-modal-close" onclick="fecharModal('modal-email')">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                    stroke-linecap="round">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>
        <form method="POST" action="Perfil.php" class="perfil-modal-form" onsubmit="return validarFormEmail()">
            <input type="hidden" name="acao" value="alterar_email">

            <div class="perfil-campo">
                <label for="novo_email">Novo E-mail</label>
                <input type="email" id="novo_email" name="novo_email" required placeholder="novo@email.com"
                    value="<?= htmlspecialchars($logado['email_usuario']) ?>">
            </div>

            <div class="perfil-campo">
                <label for="senha_atual_email">Senha Atual</label>
                <div class="input-senha-wrapper">
                    <input type="password" id="senha_atual_email" name="senha_atual_email" required
                        placeholder="Digite sua senha atual">
                    <button type="button" class="toggle-senha" onclick="toggleSenha('senha_atual_email', this)"
                        tabindex="-1">
                        <svg class="icone-olho" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                </div>
            </div>

            <div id="erro-email" class="perfil-erro-inline" style="display:none;"></div>

            <div class="perfil-modal-footer">
                <button type="button" class="btn-cancelar" onclick="fecharModal('modal-email')">Cancelar</button>
                <button type="submit" class="btn-salvar">Salvar E-mail</button>
            </div>
        </form>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════
     MODAL — Alterar Senha
══════════════════════════════════════════════════════════ -->
<div id="modal-senha" class="perfil-modal-overlay" onclick="fecharModalFora(event, 'modal-senha')">
    <div class="perfil-modal">
        <div class="perfil-modal-header">
            <h2>Alterar Senha</h2>
            <button class="perfil-modal-close" onclick="fecharModal('modal-senha')">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                    stroke-linecap="round">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>
        <form method="POST" action="Perfil.php" class="perfil-modal-form" onsubmit="return validarFormSenha()">
            <input type="hidden" name="acao" value="alterar_senha">

            <div class="perfil-campo">
                <label for="senha_atual">Senha Atual</label>
                <div class="input-senha-wrapper">
                    <input type="password" id="senha_atual" name="senha_atual" required
                        placeholder="Digite sua senha atual">
                    <button type="button" class="toggle-senha" onclick="toggleSenha('senha_atual', this)" tabindex="-1">
                        <svg class="icone-olho" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="perfil-campo">
                <label for="nova_senha">Nova Senha</label>
                <div class="input-senha-wrapper">
                    <input type="password" id="nova_senha" name="nova_senha" required placeholder="Mínimo 6 caracteres"
                        minlength="6">
                    <button type="button" class="toggle-senha" onclick="toggleSenha('nova_senha', this)" tabindex="-1">
                        <svg class="icone-olho" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="perfil-campo">
                <label for="confirmar_senha">Confirmar Nova Senha</label>
                <div class="input-senha-wrapper">
                    <input type="password" id="confirmar_senha" name="confirmar_senha" required
                        placeholder="Repita a nova senha">
                    <button type="button" class="toggle-senha" onclick="toggleSenha('confirmar_senha', this)"
                        tabindex="-1">
                        <svg class="icone-olho" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                </div>
            </div>

            <div id="erro-senha" class="perfil-erro-inline" style="display:none;"></div>

            <div class="perfil-modal-footer">
                <button type="button" class="btn-cancelar" onclick="fecharModal('modal-senha')">Cancelar</button>
                <button type="submit" class="btn-salvar">Salvar Senha</button>
            </div>
        </form>
    </div>
</div>

<!-- ── Estilos dos modais e novos componentes ─────────────── -->
<style>
    /* ── Info grid ── */
    .perfil-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 0;
    }

    .perfil-info-item {
        padding: var(--space-lg) var(--space-xl);
        border-right: 1px solid var(--color-border);
        border-bottom: 1px solid var(--color-border);
        display: flex;
        flex-direction: column;
        gap: var(--space-xs);
    }

    .perfil-info-item:last-child,
    .perfil-info-item:nth-child(2n) {
        border-right: none;
    }

    .perfil-info-label {
        font-size: var(--text-xs);
        font-weight: var(--font-bold);
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--color-text-secondary);
    }

    .perfil-info-value {
        font-size: var(--text-md);
        color: var(--color-text);
        font-weight: var(--font-medium);
    }

    /* ── Botão editar ── */
    .btn-editar {
        display: inline-flex;
        align-items: center;
        gap: var(--space-sm);
        padding: var(--space-sm) var(--space-lg);
        background: rgba(175, 193, 248, 0.12);
        color: var(--color-accent-light);
        font-family: var(--font-secondary);
        font-size: var(--text-sm);
        font-weight: var(--font-medium);
        border: 1px solid rgba(175, 193, 248, 0.25);
        border-radius: var(--radius-md);
        cursor: pointer;
        transition: background 0.2s, transform 0.15s;
        white-space: nowrap;
    }

    .btn-editar:hover {
        background: rgba(175, 193, 248, 0.22);
        transform: translateY(-1px);
    }

    /* ── Feedback banner ── */
    .perfil-feedback {
        display: flex;
        align-items: center;
        gap: var(--space-sm);
        padding: var(--space-md) var(--space-xl);
        border-radius: var(--radius-md);
        font-size: var(--text-sm);
        font-weight: var(--font-medium);
        border: 1px solid;
    }

    .perfil-feedback--sucesso {
        background: #F0FBF0;
        color: var(--color-success);
        border-color: #AEDCAE;
    }

    .perfil-feedback--erro {
        background: #FEF2F2;
        color: var(--color-error);
        border-color: #FECACA;
    }

    /* ── Modal overlay ── */
    .perfil-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(22, 31, 57, 0.55);
        backdrop-filter: blur(3px);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        padding: var(--space-xl);
    }

    .perfil-modal-overlay.aberto {
        display: flex;
    }

    /* ── Modal box ── */
    .perfil-modal {
        background: var(--color-bg);
        border-radius: var(--radius-lg);
        box-shadow: 0 20px 60px rgba(22, 31, 57, 0.25);
        width: 100%;
        max-width: 420px;
        animation: modalEntrar 0.2s ease;
    }

    @keyframes modalEntrar {
        from {
            opacity: 0;
            transform: scale(0.95) translateY(-8px);
        }

        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .perfil-modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: var(--space-xl);
        border-bottom: 1px solid var(--color-border);
    }

    .perfil-modal-header h2 {
        font-family: var(--font-primary);
        font-size: var(--text-xl);
        color: var(--color-primary);
    }

    .perfil-modal-close {
        background: none;
        border: none;
        cursor: pointer;
        color: var(--color-text-secondary);
        display: flex;
        align-items: center;
        padding: var(--space-xs);
        border-radius: var(--radius-sm);
        transition: color 0.15s, background 0.15s;
    }

    .perfil-modal-close:hover {
        color: var(--color-primary);
        background: var(--color-bg-soft);
    }

    .perfil-modal-form {
        padding: var(--space-xl);
        display: flex;
        flex-direction: column;
        gap: var(--space-lg);
    }

    /* ── Campos ── */
    .perfil-campo {
        display: flex;
        flex-direction: column;
        gap: var(--space-xs);
    }

    .perfil-campo label {
        font-size: var(--text-sm);
        font-weight: var(--font-bold);
        color: var(--color-text);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .perfil-campo input {
        width: 100%;
        padding: var(--space-md) var(--space-lg);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
        font-family: var(--font-secondary);
        font-size: var(--text-md);
        color: var(--color-text);
        background: var(--color-bg-soft);
        transition: border-color 0.2s, box-shadow 0.2s;
        box-sizing: border-box;
    }

    .perfil-campo input:focus {
        outline: none;
        border-color: var(--color-accent);
        box-shadow: 0 0 0 3px rgba(92, 147, 170, 0.15);
        background: var(--color-bg);
    }

    /* ── Esconde o ícone nativo de revelar senha do Chrome/Edge ── */
    input[type="password"]::-ms-reveal,
    input[type="password"]::-ms-clear {
        display: none;
    }

    input[type="password"]::-webkit-credentials-auto-fill-button,
    input[type="password"]::-webkit-strong-password-auto-fill-button {
        display: none;
    }

    /* ── Input senha com olho ── */
    .input-senha-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-senha-wrapper input {
        padding-right: 44px;
    }

    .toggle-senha {
        position: absolute;
        right: 10px;
        background: none;
        border: none;
        cursor: pointer;
        color: var(--color-text-secondary);
        display: flex;
        align-items: center;
        padding: 4px;
        transition: color 0.15s;
    }

    .toggle-senha:hover {
        color: var(--color-primary);
    }

    /* ── Erro inline no modal ── */
    .perfil-erro-inline {
        display: flex;
        align-items: center;
        gap: var(--space-sm);
        padding: var(--space-sm) var(--space-md);
        background: #FEF2F2;
        color: var(--color-error);
        border: 1px solid #FECACA;
        border-radius: var(--radius-md);
        font-size: var(--text-sm);
    }

    /* ── Footer do modal ── */
    .perfil-modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: var(--space-sm);
        padding-top: var(--space-sm);
    }

    .btn-cancelar {
        padding: var(--space-sm) var(--space-xl);
        background: transparent;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
        font-family: var(--font-secondary);
        font-size: var(--text-sm);
        color: var(--color-text-secondary);
        cursor: pointer;
        transition: background 0.15s;
    }

    .btn-cancelar:hover {
        background: var(--color-bg-soft);
    }

    .btn-salvar {
        padding: var(--space-sm) var(--space-xl);
        background: var(--color-primary);
        color: var(--color-text-light);
        border: none;
        border-radius: var(--radius-md);
        font-family: var(--font-secondary);
        font-size: var(--text-sm);
        font-weight: var(--font-bold);
        cursor: pointer;
        transition: background 0.2s, transform 0.15s;
    }

    .btn-salvar:hover {
        background: var(--color-primary-dark);
        transform: translateY(-1px);
    }

    @media (max-width: 700px) {
        .perfil-info-grid {
            grid-template-columns: 1fr;
        }

        .perfil-info-item {
            border-right: none;
        }

        .perfil-hero-actions {
            flex-direction: row !important;
            flex-wrap: wrap;
            align-items: center !important;
        }
    }
</style>

<script>
    function abrirModal(id) {
        document.getElementById(id).classList.add('aberto');
        document.body.style.overflow = 'hidden';
    }
    function fecharModal(id) {
        document.getElementById(id).classList.remove('aberto');
        document.body.style.overflow = '';
    }
    function fecharModalFora(event, id) {
        if (event.target === document.getElementById(id)) fecharModal(id);
    }

    function toggleSenha(inputId, btn) {
        const input = document.getElementById(inputId);
        const visivel = input.type === 'text';
        input.type = visivel ? 'password' : 'text';
        // Troca ícone
        const svg = btn.querySelector('svg');
        if (visivel) {
            svg.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
        } else {
            svg.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
        }
    }

    function validarFormEmail() {
        const erro = document.getElementById('erro-email');
        const novoEmail = document.getElementById('novo_email').value.trim();
        const senha = document.getElementById('senha_atual_email').value;
        if (!novoEmail || !senha) {
            erro.textContent = 'Preencha todos os campos.';
            erro.style.display = 'flex';
            return false;
        }
        erro.style.display = 'none';
        return true;
    }

    function validarFormSenha() {
        const erro = document.getElementById('erro-senha');
        const nova = document.getElementById('nova_senha').value;
        const confirmar = document.getElementById('confirmar_senha').value;
        if (nova !== confirmar) {
            erro.textContent = 'A nova senha e a confirmação não coincidem.';
            erro.style.display = 'flex';
            return false;
        }
        if (nova.length < 6) {
            erro.textContent = 'A nova senha deve ter pelo menos 6 caracteres.';
            erro.style.display = 'flex';
            return false;
        }
        erro.style.display = 'none';
        return true;
    }

    // Fecha modal com ESC
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            fecharModal('modal-email');
            fecharModal('modal-senha');
        }
    });
</script>

</body>

</html>