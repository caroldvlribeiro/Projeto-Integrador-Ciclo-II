<?php

require_once __DIR__ . '/../models/MovimentacaoEstoque.php';

class MovimentacaoEstoqueController
{
    private MovimentacaoEstoque $model;

    public function __construct(PDO $conn)
    {
        $this->model = new MovimentacaoEstoque($conn);
    }

    public function listar(): array
    {
        return $this->model->listarTodos();
    }

    public function buscar(int $id): mixed
    {
        return $this->model->buscarPorId($id);
    }

    public function listarPorProduto(int $idProduto): array
    {
        return $this->model->listarPorProduto($idProduto);
    }

    public function registrarEntrada(int $idProduto, int|float $quantidade): bool
    {
        $this->model->setProduto($idProduto);
        $this->model->setQuantidade($quantidade);
        $this->model->setTipo('Entrada');
        return $this->model->salvar();
    }

    public function registrarSaida(int $idProduto, int|float $quantidade): bool
    {
        $this->model->setProduto($idProduto);
        $this->model->setQuantidade($quantidade);
        $this->model->setTipo('Saída');
        return $this->model->salvar();
    }

    public function getErro(): ?string
    {
        return $this->model->getError();
    }
}