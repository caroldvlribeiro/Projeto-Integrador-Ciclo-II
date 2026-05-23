<?php
$paginaAtiva = 'agenda';
$tituloPagina = 'Agenda - Marmoraria';
$cssExtra = '../assets/css/agenda.css';
include './includes/usuario.php';
include './includes/layout.php';


    if (isset($_GET['acao']) && $_GET['acao'] === 'logout') {
        session_destroy();

        header('Location: Login.php');
        exit;
    }
?>

        <main class="dashboard">

    <section class="development-container">

        <div class="development-card">

            <div class="icon">
                🚧
            </div>

            <h1>Página em Desenvolvimento</h1>

            <p>
                Estamos preparando uma experiência ainda melhor para o gerenciamento
                da agenda da marmoraria.
            </p>

            <span>
                Novas funcionalidades estarão disponíveis em breve.
            </span>

            <a href="Dashboard.php" class="btn-voltar">
                Voltar ao Dashboard
            </a>

        </div>

    </section>

</main>