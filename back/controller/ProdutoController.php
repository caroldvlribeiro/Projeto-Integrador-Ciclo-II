<?php

require_once __DIR__ . '/../models/Produto.php';

class ProdutoController
{
    private Produto $model;
    private ?string $erro = null;

    public function __construct(PDO $conn)
    {
        $this->model = new Produto($conn);
    }

    public function listar(): array
    {
        return $this->model->listarTodos();
    }

    public function listarComCategoria(PDO $pdo): array
    {
        $sql = "SELECT p.id_produto, p.nm_produto, p.ds_produto, p.vl_produto,
                       p.id_categoria, c.nm_categoria
                FROM produto p
                LEFT JOIN categoria_produto c ON p.id_categoria = c.id_categoria
                ORDER BY p.id_produto ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function salvar(int $idCategoria, string $nome, string $descricao, float $valor): bool
    {
        $this->erro = null;
        $this->model->setCategoria($idCategoria);
        $this->model->setNome($nome);
        $this->model->setDescricao($descricao);
        $this->model->setVlVenda($valor);
        if (!$this->model->salvar()) {
            $this->erro = $this->model->getError() ?? 'Falha ao salvar produto.';
            return false;
        }
        return true;
    }

    public function atualizar(int $id, int $idCategoria, string $nome, string $descricao, float $valor): bool
    {
        $this->erro = null;
        $this->model->setCategoria($idCategoria);
        $this->model->setNome($nome);
        $this->model->setDescricao($descricao);
        $this->model->setVlVenda($valor);
        if (!$this->model->atualizar($id)) {
            $this->erro = $this->model->getError() ?? 'Falha ao atualizar produto.';
            return false;
        }
        return true;
    }

    public function deletar(int $id): bool
    {
        $this->erro = null;
        if (!$this->model->deletar($id)) {
            $this->erro = 'Falha ao deletar produto.';
            return false;
        }
        return true;
    }

    public function getErro(): ?string
    {
        return $this->erro;
    }
}
