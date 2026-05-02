<?php
require_once 'Pessoa.php';
require_once __DIR__ . '/../interfaces/IAutenticavel.php';

/**
 * Model Usuario
 * Gerencia os dados da tabela 'usuario' e lida com login administrativo.
 */
class Usuario extends Pessoa implements IAutenticavel
{
    protected $tp_usuario; // Tipo: Administrador ou Vendedor

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo, 'usuario');
    }

    public function setTipo($tipo)
    {
        $this->tp_usuario = $tipo;
    }
    public function getTipo()
    {
        return $this->tp_usuario;
    }

    public function getPerfil(): string
    {
        return "Usuário: {$this->nome} | Tipo: {$this->tp_usuario}";
    }

    // Verifica se o usuário tem privilégios de administrador
    public function isAdmin(): bool
    {
        return $this->tp_usuario === 'Administrador';
    }

    // Salva um novo usuário com senha criptografada
    public function salvar(): bool
    {
        $dados = [
            'nm_usuario' => $this->nome,
            'cd_senha' => $this->senha,
            'tp_usuario' => $this->tp_usuario
        ];

        if ($this->validar($dados)) {
            $sql = "INSERT INTO {$this->_table} (nm_usuario, cd_senha, tp_usuario) 
                    VALUES (:nm_usuario, :cd_senha, :tp_usuario)";
            return $this->executar($sql, $dados);
        }
        return false;
    }

    // Atualiza dados do usuário (senha é opcional na atualização)
    public function atualizar(int $id): bool
    {
        $dados = [
            'id' => $id,
            'nm_usuario' => $this->nome,
            'tp_usuario' => $this->tp_usuario
        ];

        if ($this->validar($dados)) {
            $sql = "UPDATE {$this->_table} SET nm_usuario = :nm_usuario, tp_usuario = :tp_usuario";
            if ($this->senha) {
                $sql .= ", cd_senha = :cd_senha";
                $dados['cd_senha'] = $this->senha;
            }
            $sql .= " WHERE id_usuario = :id";
            return $this->executar($sql, $dados);
        }
        return false;
    }

    /**
     * Realiza a autenticação comparando o hash da senha.
     */
    public function autenticar(string $usuario, string $senha): bool
    {
        $sql = "SELECT * FROM {$this->_table} WHERE nm_usuario = :nome";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute(['nome' => $usuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($senha, $user['cd_senha'])) {
            if (session_status() === PHP_SESSION_NONE)
                session_start();
            $_SESSION['usuario'] = $user;
            return true;
        }
        return false;
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
        }
    }

    public function temPermissao(string $acao): bool
    {
        return $this->isAdmin();
    }
}

?>