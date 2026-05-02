<?php
require_once 'ItemEstoque.php';

class Produto extends ItemEstoque
{
    private $idProduto;
    private $idCategoria;

    public function __construct(PDO $PDO)
    {
        parent::__construct($PDO, 'produtos');
    }

    public function getIdProduto()
    {
        return $this->idProduto;
    }

    public function setIdProduto($idProduto)
    {
        $this->idProduto = $idProduto;
    }

    public function getIdCategoria()
    {
        return $this->idCategoria;
    }

    public function setIdCategoria($idCategoria)
    {
        $this->idCategoria = $idCategoria;
    }

    // MÉTODOS DO DIAGRAMA
    public function calcularVlVenda()
    {
        // Exemplo de lógica: margem de 30% para produtos prontos
        $this->vlVenda = $this->vlCompra * 1.3;
        return $this->vlVenda;
    }

    public function listarPorCategoria($id)
    {
        $sql = "SELECT * FROM {$this->_table} WHERE idCategoria = :id";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>