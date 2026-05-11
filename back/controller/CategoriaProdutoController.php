<?php

/**
 * CategoriaProdutoController
 * 
 * Função: receber pedidos da View, conversar com o Model,
 * e devolver os dados pra View montar a tela.
 */

require_once  '/../models/CategoriaProduto.php';

class CategoriaProdutoController
{
    private $model;

    public function __construct(PDO $conn)
    {
        $this->model = new CategoriaProduto($conn);
    }

    public function listar(): array
    {
        return $this->model->listarTodos();
    }
}