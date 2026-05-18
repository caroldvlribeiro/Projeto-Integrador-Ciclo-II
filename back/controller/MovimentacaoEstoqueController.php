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

    /**
     * Método único que a view usa: registra uma movimentação
     * recebendo o tipo como parâmetro ('Entrada' ou 'Saída').
     */
    public function registrar(int $idProduto, string $tipo, int|float $quantidade): bool
    {
        $tipo = trim($tipo);
        if ($tipo === 'E') $tipo = 'Entrada';
        if ($tipo === 'S') $tipo = 'Saída';

        if (!in_array($tipo, ['Entrada', 'Saída'], true)) {
            return false;
        }

        $this->model->setProduto($idProduto);
        $this->model->setQuantidade($quantidade);
        $this->model->setTipo($tipo);
        return $this->model->salvar();
    }

    public function registrarEntrada(int $idProduto, int|float $quantidade): bool
    {
        return $this->registrar($idProduto, 'Entrada', $quantidade);
    }

    public function registrarSaida(int $idProduto, int|float $quantidade): bool
    {
        return $this->registrar($idProduto, 'Saída', $quantidade);
    }

    public function getErro(): ?string
    {
        return $this->model->getError();
    }
}