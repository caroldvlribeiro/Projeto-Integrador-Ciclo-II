<?php
require_once 'Pessoa.php';
require_once '../interfaces/IAutenticavel.php';

class Usuario extends Pessoa implements IAutenticavel
{

    private $idUsuario;
    private $tpUsuario;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo, 'usuarios');
    }

    // SETTERS
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function setTpUsuario($tpUsuario)
    {
        $tiposValidos = ['admin', 'vendedor', 'cliente'];

        if (!in_array($tpUsuario, $tiposValidos)) {
            throw new Exception("Tipo de usuário inválido");
        }

        $this->tpUsuario = $tpUsuario;
    }

    // GETTERS
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function getTpUsuario()
    {
        return $this->tpUsuario;
    }

    // MÉTODOS DO DIAGRAMA
    public function getPerfil(): string
    {
        return "Usuário: {$this->nome} | Tipo: {$this->tpUsuario}";
    }

    public function isAdmin(): bool
    {
        return $this->tpUsuario === 'admin';
    }

    // CREATE
    public function salvar(): bool
    {
        $dados = [
            'nome' => $this->nome,
            'telefone' => $this->telefone,
            'senha' => $this->senha,
            'tp_usuario' => $this->tpUsuario
        ];

        if ($this->validar($dados)) {
            $sql = "INSERT INTO {$this->_table} 
                    (nome, telefone, senha, tp_usuario) 
                    VALUES (:nome, :telefone, :senha, :tp_usuario)";
            return $this->executar($sql, $dados);
        }
        return false;
    }

    // UPDATE
    public function atualizar(int $id): bool
    {
        $dados = [
            'id' => $id,
            'nome' => $this->nome,
            'telefone' => $this->telefone,
            'tp_usuario' => $this->tpUsuario
        ];

        if ($this->validar($dados)) {
            $sql = "UPDATE {$this->_table} SET 
                    nome = :nome, 
                    telefone = :telefone,
                    tp_usuario = :tp_usuario";

            if ($this->senha) {
                $sql .= ", senha = :senha";
                $dados['senha'] = $this->senha;
            }

            $sql .= " WHERE id = :id";

            return $this->executar($sql, $dados);
        }
        return false;
    }

    // LOGIN (IAutenticavel)
    public function autenticar(string $usuario, string $senha): bool
    {
        $sql = "SELECT * FROM {$this->_table} WHERE nome = :nome";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute(['nome' => $usuario]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($senha, $user['senha'])) {
            unset($user['senha']);

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            session_regenerate_id(true);
            $_SESSION['usuario'] = $user;

            return true;
        }

        return false;
    }

    // LOGOUT (IAutenticavel)
    public function logout(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
        }
    }

    // PERMISSÃO (IAutenticavel)
    public function temPermissao(string $acao): bool
    {
        if ($this->tpUsuario === 'admin') {
            return true;
        }

        if ($this->tpUsuario === 'vendedor' && $acao === 'vender') {
            return true;
        }

        return false;
    }
}
?>