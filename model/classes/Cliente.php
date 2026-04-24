<?php

class Cliente {
    public $id;
    public $nome;
    public $endereco;
    public $telefone;

    public function __construct($id, $nome, $endereco, $telefone) {
        $this->id = $id;
        $this->nome = $nome;
        $this->endereco = $endereco;
        $this->telefone = $telefone;
    }
}
?>