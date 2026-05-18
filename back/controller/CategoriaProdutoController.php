<?php

/**
 * CategoriaProdutoController
 * 
 * Função: receber pedidos da View, conversar com o Model,
 * e devolver os dados pra View montar a tela.
 */

require_once __DIR__ . '/../models/CategoriaProduto.php';

class CategoriaProdutoController
{
    private CategoriaProduto $model;
    private ?string $erro = null;

    public function __construct(PDO $conn)
    {
        $this->model = new CategoriaProduto($conn);
    }

    public function listar(): array
    {
        return $this->model->listarTodos();
    }

    public function salvar(string $nome, string $descricao): bool
    {
        $this->erro = null;
        $this->model->setNome($nome);
        $this->model->setDescricao($descricao);
        if (!$this->model->salvar()) {
            $this->erro = 'Falha ao salvar categoria.';
            return false;
        }
        return true;
    }

    public function atualizar(int $id, string $nome, string $descricao): bool
    {
        $this->erro = null;
        $this->model->setNome($nome);
        $this->model->setDescricao($descricao);
        if (!$this->model->atualizar($id)) {
            $this->erro = 'Falha ao atualizar categoria.';
            return false;
        }
        return true;
    }

    public function deletar(int $id): bool
    {
        $this->erro = null;
        if (!$this->model->deletar($id)) {
            $this->erro = 'Falha ao deletar categoria.';
            return false;
        }
        return true;
    }

    public function getErro(): ?string
    {
        return $this->erro;
    }
}