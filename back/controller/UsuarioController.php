<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Usuario.php';

/**
 * Gerencia edição de conta do usuário logado:
 * alteração de e-mail e senha, ambas exigindo confirmação da senha atual.
 */
class UsuarioController
{
    private $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    /**
     * Altera o e-mail do usuário logado.
     * Verifica senha atual, garante unicidade do novo e-mail e atualiza a sessão.
     */
    public function alterarEmail(int $idUsuario, string $novoEmail, string $senhaAtual): array
    {
        $stmt = $this->pdo->prepare("SELECT cd_senha FROM usuario WHERE id_usuario = :id");
        $stmt->execute(['id' => $idUsuario]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // password_verify compara o texto puro com o hash bcrypt salvo no banco
        if (!$row || !password_verify($senhaAtual, $row['cd_senha'])) {
            return ['sucesso' => false, 'erro' => 'Senha atual incorreta.'];
        }

        // "id_usuario != :id" exclui o próprio usuário da checagem de unicidade
        $stmt2 = $this->pdo->prepare(
            "SELECT id_usuario FROM usuario WHERE email_usuario = :email AND id_usuario != :id"
        );
        $stmt2->execute(['email' => $novoEmail, 'id' => $idUsuario]);
        if ($stmt2->fetch()) {
            return ['sucesso' => false, 'erro' => 'Este e-mail já está em uso.'];
        }

        $stmt3 = $this->pdo->prepare(
            "UPDATE usuario SET email_usuario = :email WHERE id_usuario = :id"
        );
        $ok = $stmt3->execute(['email' => $novoEmail, 'id' => $idUsuario]);

        if ($ok) {
            // Atualiza a sessão para refletir o novo e-mail sem precisar relogar
            $_SESSION['usuario']['email_usuario'] = $novoEmail;
            return ['sucesso' => true];
        }

        return ['sucesso' => false, 'erro' => 'Erro ao atualizar e-mail. Tente novamente.'];
    }

    /**
     * Altera a senha do usuário logado.
     * Valida confirmação e tamanho mínimo antes de bater no banco.
     */
    public function alterarSenha(int $idUsuario, string $senhaAtual, string $novaSenha, string $confirmarSenha): array
    {
        if ($novaSenha !== $confirmarSenha) {
            return ['sucesso' => false, 'erro' => 'A nova senha e a confirmação não coincidem.'];
        }

        if (strlen($novaSenha) < 6) {
            return ['sucesso' => false, 'erro' => 'A nova senha deve ter pelo menos 6 caracteres.'];
        }

        $stmt = $this->pdo->prepare("SELECT cd_senha FROM usuario WHERE id_usuario = :id");
        $stmt->execute(['id' => $idUsuario]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row || !password_verify($senhaAtual, $row['cd_senha'])) {
            return ['sucesso' => false, 'erro' => 'Senha atual incorreta.'];
        }

        // Nunca salva senha em texto puro — sempre gera hash bcrypt
        $hash = password_hash($novaSenha, PASSWORD_DEFAULT);

        $stmt2 = $this->pdo->prepare(
            "UPDATE usuario SET cd_senha = :senha WHERE id_usuario = :id"
        );
        $ok = $stmt2->execute(['senha' => $hash, 'id' => $idUsuario]);

        if ($ok) {
            return ['sucesso' => true];
        }

        return ['sucesso' => false, 'erro' => 'Erro ao atualizar senha. Tente novamente.'];
    }
}