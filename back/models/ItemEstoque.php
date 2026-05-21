<?php
require_once 'Model.php';

/**
 * Classe Abstrata ItemEstoque
 * Base para materiais e produtos (Pedras, Cubas, etc).
 */
abstract class ItemEstoque extends Model
{
    protected $nome;
    protected $descricao;
    protected $vlCompra;
    protected $vlVenda;

    public function __construct(PDO $PDO, $table)
    {
        parent::__construct($PDO, $table);
    }

    // Getters e Setters
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

    /**
     * Calcula a porcentagem de lucro (margem) do item.
     */
    public function calcularMargem()
    {
        if ($this->vlCompra > 0) {
            return (($this->vlVenda - $this->vlCompra) / $this->vlCompra) * 100;
        }
        return 0;
    }

    // Cada tipo de item terá sua própria regra de cálculo de venda
    abstract public function calcularVlVenda();
}

?>