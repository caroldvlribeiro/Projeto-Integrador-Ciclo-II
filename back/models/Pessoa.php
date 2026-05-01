<?php require_once 'Model.php';
abstract class Pessoa extends Model {
    private $id;
    private $nome;
    private $telefone;

    public function __construct(PDO $PDO, $table) {
        parent::__construct($PDO, $table);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }
}