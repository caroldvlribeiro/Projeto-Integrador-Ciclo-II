<?php
require_once 'Model.php';

/**
 * Classe Abstrata RegistroFinanceiro
 * Base para movimentações de dinheiro (Vendas, Pagamentos).
 */
abstract class RegistroFinanceiro extends Model
{
    protected $idOrcamento;
    protected $vlTotal;
    protected $dtRegistro;

    public function __construct(PDO $PDO, $table)
    {
        parent::__construct($PDO, $table);
    }

    // Getters e Setters
    public function getIdOrcamento()
    {
        return $this->idOrcamento;
    }
    public function setIdOrcamento($id)
    {
        $this->idOrcamento = $id;
    }

    public function getVlTotal()
    {
        return $this->vlTotal;
    }
    public function setVlTotal($valor)
    {
        $this->vlTotal = $valor;
    }

    public function getDtRegistro()
    {
        return $this->dtRegistro;
    }
    public function setDtRegistro($data)
    {
        $this->dtRegistro = $data;
    }

    // Cada registro financeiro calcula seu valor total de forma específica
    abstract public function calcularValor(): float;
}

?>