<?php require_once 'Model.php';
abstract class  Pessoa extends Model {
    private $nome;
    private $telefone;
    private $senha;
    public function __construct(PDO $PDO, $table) {
        parent::__construct($PDO, $table);
    }
    public function getNome() {
        return $this->nome;
    }
    public function setNome($nome) {
        $this->nome = $nome;
    }
    public function getTelefone() {
        return $this->telefone;
    }
    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }
    public function getSenha() {
        return $this->senha;
    }
    public function setSenha($senha) {
        $this->senha = $senha;
    }
    public function salvar() {
        $dados = [
            'nome' => $this->getNome(),
            'telefone' => $this->getTelefone(),
            'senha' => $this->getSenha()
        ];
        if ($this->validar($dados)) {
            $sql = "INSERT INTO {$this->_table} (nome, telefone, senha) VALUES (:nome, :telefone, :senha)";
            return $this->executar($sql, $dados);
        }return false;
    }
    public function atualizar($id) {
        $dados = [
            'nome' => $this->getNome(),
            'telefone' => $this->getTelefone(),
            'senha' => $this->getSenha()
        ];
        if ($this->validar($dados)) {
            $sql = "UPDATE {$this->_table} SET nome = :nome, telefone = :telefone, senha = :senha WHERE id = :id";
            $dados['id'] = $id;
            return $this->executar($sql, $dados);
        }
        return false;
    }
}