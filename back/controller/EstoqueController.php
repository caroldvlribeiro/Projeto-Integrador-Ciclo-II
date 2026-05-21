<?php

require_once __DIR__ . '/../models/Estoque.php';

class EstoqueController
{
    private Estoque $model;

    public function __construct(PDO $conn)
    {
        $this->model = new Estoque($conn);
    }

    public function listar(): array
    {
        return $this->model->listarTodos();
    }

    public function buscar(int $id): mixed
    {
        return $this->model->buscarPorId($id);
    }

    public function saldoPorProduto(int $idProduto): int|float
    {
        return $this->model->buscarSaldoPorProduto($idProduto);
    }

    public function salvar(int $idProduto, int|float $quantidade): bool
    {
        $this->model->setProduto($idProduto);
        $this->model->setQuantidade($quantidade);
        return $this->model->salvar();
    }

    public function atualizar(int $id, int|float $quantidade): bool
    {
        $this->model->setQuantidade($quantidade);
        return $this->model->atualizar($id);
    }

    public function deletar(int $id): bool
    {
        return $this->model->deletar($id);
    }

    public function getErro(): ?string
    {
        return $this->model->getError();
    }
}
