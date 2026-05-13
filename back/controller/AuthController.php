<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Usuario.php';

class AuthController
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    // Tenta autenticar o usuário e seta o cookie se "lembrar" marcado
    public function login(string $nome, string $senha, bool $lembrar = false): array
    {
        $usuario = new Usuario($this->conn);
        if ($usuario->autenticar($nome, $senha)) {
            $this->setCookie($nome, $lembrar);
            return ['sucesso' => true];
        }
        return ['sucesso' => false, 'erro' => 'Nome ou senha inválidos.'];
    }

    // Destrói a sessão mas mantém o cookie para preencher o nome no login
    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        session_unset();
        session_destroy();
        header('Location: ../front/login.php');
        exit;
    }

    // Redireciona para login se não houver sessão ativa
    public function verificarSessao(): void
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        if (!isset($_SESSION['usuario'])) {
            header('Location: ../front/login.php');
            exit;
        }
    }

    // Salva o nome do usuário no cookie por 7 dias
    private function setCookie(string $nome, bool $lembrar): void
    {
        if ($lembrar) {
            setcookie('usuario_nome', $nome, time() + (7 * 24 * 60 * 60), '/');
        }
    }
}