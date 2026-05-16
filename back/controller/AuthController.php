<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Usuario.php';

class AuthController
{
    private $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    // Tenta autenticar o usuário e seta o cookie se "lembrar" marcado
    public function login(string $email, string $senha, bool $lembrar = false): array
    {
        $usuario = new Usuario($this->pdo);
        if ($usuario->autenticar($email, $senha)) {
            $this->setCookie($email, $lembrar);
            return ['sucesso' => true];
        }
        return ['sucesso' => false, 'erro' => 'Email ou senha inválidos.'];
    }

    // Destrói a sessão mas mantém o cookie para preencher o email no login
    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        session_unset();
        session_destroy();
        header('Location: Login.php');
        exit;
    }

    // Redireciona para login se não houver sessão ativa
    public function verificarSessao(): void
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        if (!isset($_SESSION['usuario'])) {
            header('Location: Login.php');
            exit;
        }
    }

    // Salva o email do usuário no cookie por 7 dias
    private function setCookie(string $email, bool $lembrar): void
    {
        if ($lembrar) {
            setcookie('usuario_email', $email, time() + (7 * 24 * 60 * 60), '/');
        }
    }
}