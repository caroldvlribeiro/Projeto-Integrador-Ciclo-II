<?php
require_once 'Model.php';
abstract class RegistroFinanceiro extends Model
{
    protected $idOrcamento;
    protected $vlTotal;
    protected $dtRegistro;

    public function __construct(PDO $PDO, $table)
    {
        parent::__construct($PDO, $table);
    }

    public function getIdOrcamento()
    {
        return $this->idOrcamento;
    }
    public function setIdOrcamento($idOrcamento)
    {
        $this->idOrcamento = $idOrcamento;
    }
    public function getVlTotal()
    {
        return $this->vlTotal;
    }
    public function setVlTotal($vlTotal)
    {
        $this->vlTotal = $vlTotal;
    }
    public function getDtRegistro()
    {
        return $this->dtRegistro;
    }
    public function setDtRegistro($dtRegistro)
    {
        $this->dtRegistro = $dtRegistro;
    }

    // Função faltante: calcularValor conforme diagrama
    abstract public function calcularValor();

    // Métodos abstratos do Model para implementação nas classes filhas (Venda, Pagamento)
    abstract public function salvar(): bool;
    abstract public function atualizar(int $id): bool;
}
?>