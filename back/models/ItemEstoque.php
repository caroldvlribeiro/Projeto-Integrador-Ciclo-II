<?php
require_once 'Model.php';
abstract class ItemEstoque extends Model
{
    protected $nome;
    protected $descricao;
    protected $vlCompra;
    protected $vlVenda; // Adicionado conforme diagrama

    public function __construct(PDO $PDO, $table)
    {
        parent::__construct($PDO, $table);
    }

    public function getNome()
    {
        return $this->nome;
    }
    public function setNome($nome)
    {
        $this->nome = $nome;
    }
    public function getDescricao()
    {
        return $this->descricao;
    }
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }
    public function getVlCompra()
    {
        return $this->vlCompra;
    }
    public function setVlCompra($vlCompra)
    {
        $this->vlCompra = $vlCompra;
    }
    public function getVlVenda()
    {
        return $this->vlVenda;
    }
    public function setVlVenda($vlVenda)
    {
        $this->vlVenda = $vlVenda;
    }

    // Função faltante: calcularMargem conforme diagrama
    public function calcularMargem()
    {
        if ($this->vlCompra > 0) {
            return (($this->vlVenda - $this->vlCompra) / $this->vlCompra) * 100;
        }
        return 0;
    }

    // Função faltante: calcularVlVenda conforme seu arquivo original
    abstract public function calcularVlVenda();

    public function salvar(): bool
    {
        $dados = [
            'nome' => $this->getNome(),
            'descricao' => $this->getDescricao(),
            'vlCompra' => $this->getVlCompra(),
            'vlVenda' => $this->getVlVenda()
        ];
        if ($this->validar($dados)) {
            $sql = "INSERT INTO {$this->_table} (nome, descricao, vlCompra, vlVenda) VALUES (:nome, :descricao, :vlCompra, :vlVenda)";
            return $this->executar($sql, $dados);
        }
        return false;
    }
    public function atualizar(int $id): bool
    {
        $dados = [
            'nome' => $this->getNome(),
            'descricao' => $this->getDescricao(),
            'vlCompra' => $this->getVlCompra(),
            'vlVenda' => $this->getVlVenda()
        ];
        if ($this->validar($dados)) {
            $sql = "UPDATE {$this->_table} SET nome = :nome, descricao = :descricao, vlCompra = :vlCompra, vlVenda = :vlVenda WHERE id = :id";
            $dados['id'] = $id;
            return $this->executar($sql, $dados);
        }
        return false;
    }
}
?>