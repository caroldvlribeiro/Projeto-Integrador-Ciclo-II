<?php

class Produto {
    private $id;
    private $nome;
    private $preco;
    private $estoque;

    public function __construct($id, $nome, $preco, $estoque) {
        $this->id = $id;
        $this->nome = $nome;
        $this->preco = $preco;
        $this->estoque = $estoque;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getPreco() {
        return $this->preco;
    }

    public function getEstoque() {
        return $this->estoque;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setPreco($preco) {
        $this->preco = $preco;
    }

    public function setEstoque($estoque) {
        $this->estoque = $estoque;
    }
}
?>