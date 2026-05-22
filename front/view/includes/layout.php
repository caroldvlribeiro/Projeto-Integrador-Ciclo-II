<?php
// Variáveis esperadas para cada página:
// $paginaAtiva  — ex: 'dashboard', 'orcamentos', 'perfil', etc.
// $tituloPagina — ex: 'Dashboard - Marmoraria'
// $csExtra      — ex: '../assets/css/dashboard.css' (opcional)
// arquivo de usuário para verificar sessão e tipo de acesso + arquivo necessário de cada view para filtros de dados ou dados específicos
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $tituloPagina ?? 'Marmoraria Nova Canaã' ?></title>
    <link rel="stylesheet" href="../assets/css/base.css">
    <?php if (!empty($cssExtra)): ?>
        <link rel="stylesheet" href="<?= $cssExtra ?>">
    <?php endif; ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
</head>

<body>
    <div class="app">
        <header class="header">
            <a href="Dashboard.php" class="logo">
                <svg width="36" height="36" viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg">
                    <rect x="2" y="2" width="52" height="52" fill="none" stroke="#EFF2F4" stroke-width="1.5" />
                    <rect x="12" y="12" width="52" height="52" fill="none" stroke="#EFF2F4" stroke-width="1.5" />
                    <rect x="22" y="22" width="52" height="52" fill="none" stroke="#EFF2F4" stroke-width="1.5" />
                    <rect x="46" y="46" width="14" height="14" fill="#EFF2F4" />
                </svg>
                <div class="title-header">
                    Nova Canaã
                    <small>Marmoraria</small>
                </div>
            </a>

            <a href="Perfil.php" class="user">
                <i class="ti ti-user-circle" style="font-size:16px;"></i>
                <?= $logado['email_usuario'] ?>
            </a>
        </header>

        <aside class="sidebar">
            <div class="nav-label">Menu</div>
            <a href="Dashboard.php" class="nav-item <?= $paginaAtiva === 'dashboard' ? 'active' : '' ?>"><i
                    class="ti ti-layout-dashboard"></i> Dashboard</a>
            <a href="Orcamentos.php" class="nav-item <?= $paginaAtiva === 'orcamentos' ? 'active' : '' ?>"><i
                    class="ti ti-file-text"></i> Orçamentos</a>
            <a href="NovoOrcamento.php" class="nav-item <?= $paginaAtiva === 'novoorcamento' ? 'active' : '' ?>"><i
                    class="ti ti-plus"></i> Novo Orçamento</a>
            <a href="Estoque.php" class="nav-item <?= $paginaAtiva === 'estoque' ? 'active' : '' ?>"><i
                    class="ti ti-stack"></i> Estoque</a>
            <a href="Agenda.php" class="nav-item <?= $paginaAtiva === 'agenda' ? 'active' : '' ?>"><i
                    class="ti ti-calendar"></i> Agenda</a>
            <a href="Produtos.php" class="nav-item <?= $paginaAtiva === 'produtos' ? 'active' : '' ?>"><i
                    class="ti ti-package"></i> Produtos</a>
            <?php if ($tipo === 'Administrador'): ?>
                <a href="Relatorio.php" class="nav-item <?= $paginaAtiva === 'relatorio' ? 'active' : '' ?>"><i
                        class="ti ti-chart-bar"></i> Relatório</a>
            <?php endif; ?>
            <a href="Perfil.php" class="nav-item <?= $paginaAtiva === 'perfil' ? 'active' : '' ?>"><i
                    class="ti ti-user"></i> Perfil</a>
        </aside>

        <main>