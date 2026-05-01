<?php 
require_once 'Pessoa.php';

class Usuario extends Pessoa implements IAutenticavel {

    private $senha;
    private $tpUsuario;

    public function __construct(PDO $pdo) {
        parent::__construct($pdo, 'usuarios');
    }

    // SETTERS
    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function setTpUsuario($tpUsuario) {
        $tiposValidos = ['admin', 'vendedor', 'cliente'];

        if (!in_array($tpUsuario, $tiposValidos)) {
            throw new Exception("Tipo de usuário inválido");
        }

        $this->tpUsuario = $tpUsuario;
    }

    // GETTERS
    public function getTpUsuario() {
        return $this->tpUsuario;
    }

    // CREATE
    public function salvar() {
        if (!$this->validar([
            $this->getNome(), 
            $this->getTelefone(), 
            $this->senha,
            $this->tpUsuario
        ])) {
            return false;
        }

        $sql = "INSERT INTO {$this->_table} 
                (nome, telefone, senha, tp_usuario) 
                VALUES (:nome, :telefone, :senha, :tp_usuario)";

        return $this->executar($sql, [
            'nome' => $this->getNome(),
            'telefone' => $this->getTelefone(),
            'senha' => password_hash($this->senha, PASSWORD_DEFAULT),
            'tp_usuario' => $this->tpUsuario
        ]);
    }

    // UPDATE
    public function atualizar() {
        if (!$this->getId()) {
            throw new Exception("ID do usuário não definido");
        }

        if (!$this->validar([
            $this->getNome(), 
            $this->getTelefone(),
            $this->tpUsuario
        ])) {
            return false;
        }

        $dados = [
            'id' => $this->getId(),
            'nome' => $this->getNome(),
            'telefone' => $this->getTelefone(),
            'tp_usuario' => $this->tpUsuario
        ];

        $sql = "UPDATE {$this->_table} SET 
                nome = :nome, 
                telefone = :telefone,
                tp_usuario = :tp_usuario";

        if ($this->senha) {
            $sql .= ", senha = :senha";
            $dados['senha'] = password_hash($this->senha, PASSWORD_DEFAULT);
        }

        $sql .= " WHERE id = :id";

        return $this->executar($sql, $dados);
    }

    // LOGIN
    public function autenticar($telefone, $senha) {
        $sql = "SELECT * FROM {$this->_table} WHERE telefone = :telefone";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute(['telefone' => $telefone]);

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {

            unset($usuario['senha']);

            // inicia sessão com segurança
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            session_regenerate_id(true);

            $_SESSION['usuario'] = $usuario;

            return $usuario;
        }

        return false;
    }

    // LOGOUT
    public function logout(){
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
        }
    }

    // PERMISSÃO
    public function temPermissao($acao){
        // exemplo simples
        if ($this->tpUsuario === 'admin') {
            return true;
        }

        if ($this->tpUsuario === 'vendedor' && $acao === 'vender') {
            return true;
        }

        return false;
    }
}