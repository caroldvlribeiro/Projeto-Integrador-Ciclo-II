<?php require_once 'Model.php';
abstract class ItemEstoque extends Model {
    private $nome;
    private $descricao;
    private $vlCompra;

    public function __construct(PDO $PDO, $table) {
        parent::__construct($PDO, $table);
    }

    public function getNome() {
        return $this->nome;
    }
    public function setNome($nome) {
        $this->nome = $nome;
    }
    public function getDescricao() {
        return $this->descricao;
    }
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
    public function getVlCompra() {
        return $this->vlCompra;
    }
    public function setVlCompra($vlCompra) {
        $this->vlCompra = $vlCompra;
    }
    public function salvar() {
        $dados = [
            'nome' => $this->getNome(),
            'descricao' => $this->getDescricao(),
            'vlCompra' => $this->getVlCompra()
        ];
        if ($this->validar($dados)) {
            $sql = "INSERT INTO {$this->_table} (nome, descricao, vlCompra) VALUES (:nome, :descricao, :vlCompra)";
            return $this->executar($sql, $dados);
        }return false;
    }
    public function atualizar($id) {
        $dados = [
            'nome' => $this->getNome(),
            'descricao' => $this->getDescricao(),
            'vlCompra' => $this->getVlCompra()
        ];
        if ($this->validar($dados)) {
            $sql = "UPDATE {$this->_table} SET nome = :nome, descricao = :descricao, vlCompra = :vlCompra WHERE id = :id";
            $dados['id'] = $id;
            return $this->executar($sql, $dados);
        }
        return false;
    }
    abstract public function calcularVlVenda();
}