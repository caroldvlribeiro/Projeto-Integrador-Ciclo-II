<?php require_once 'Model.php';
abstract class RegistroFinanceiro extends Model {
    protected $id;
    protected $valor;
    protected $data;

    public function __construct($id, $valor, $data) {
        $this->id = $id;
        $this->valor = $valor;
        $this->data = $data;
    }

    public function getId() {
        return $this->id;
    }

    public function getValor() {
        return $this->valor;
    }

    public function getData() {
        return $this->data;
    }

    abstract public function calcularValor();
}
