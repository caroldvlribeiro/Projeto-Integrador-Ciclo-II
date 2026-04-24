<?php
class Usuario {
    private $id;    
    private $nome;
    private $email;
    private $telefone;

    public function __construct($id, $nome, $email, $telefone) {
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
        $this->telefone = $telefone;
    }

    // Getters
    public function getId() {
        return $this->id;
    }
    public function getNome() {
        return $this->nome;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getTelefone() {
        return $this->telefone;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }
    public function setNome($nome) {
        $this->nome = $nome;
    }
    public function setEmail($email) {
        $this->email = $email;
    }
    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }
}
?>