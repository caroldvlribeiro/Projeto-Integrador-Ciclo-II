<?php
require_once 'ItemEstoque.php';

class Pedra extends ItemEstoque
{
    private $idPedra;

    public function __construct(PDO $PDO)
    {
        parent::__construct($PDO, 'pedras');
    }

    public function getIdPedra()
    {
        return $this->idPedra;
    }

    public function setIdPedra($idPedra)
    {
        $this->idPedra = $idPedra;
    }

    // MÉTODOS DO DIAGRAMA
    public function calcularVlVenda()
    {
        // Exemplo de lógica: margem de 50% sobre o valor de compra
        $this->vlVenda = $this->vlCompra * 1.5;
        return $this->vlVenda;
    }

    public function calcularVenda()
    {
        return $this->calcularVlVenda();
    }

    // Implementação do salvar e atualizar herdados de ItemEstoque
    // Eles já usam os atributos protected (nome, descricao, vlCompra, vlVenda)
}

?>