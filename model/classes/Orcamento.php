<?php

class Orcamento {
    private $id;
    private $cliente;
    private $dataEntrega;
    private $dataPedido;
    private $descricao;
    private $acabamento;
    private $material;
    private $cuba;
    private $vista;
    private $saia;
    private $status;
    private $vlEntrada;
    private $vlRestante;
    private $vlTotal;

    public function __construct($id, $cliente, $dataEntrega, $dataPedido, $descricao, $acabamento, $material, $cuba, $vista, $saia, $status, $vlEntrada, $vlRestante, $vlTotal) {
        $this->id = $id;
        $this->cliente = $cliente;
        $this->dataEntrega = $dataEntrega;
        $this->dataPedido = $dataPedido;
        $this->descricao = $descricao;
        $this->acabamento = $acabamento;
        $this->material = $material;
        $this->cuba = $cuba;
        $this->vista = $vista;
        $this->saia = $saia;
        $this->status = $status;
        $this->vlEntrada = $vlEntrada;
        $this->vlRestante = $vlRestante;
        $this->vlTotal = $vlTotal;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getCliente() {
        return $this->cliente;
    }

    public function getDataEntrega() {
        return $this->dataEntrega;
    }

    public function getDataPedido() {
        return $this->dataPedido;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getAcabamento() {
        return $this->acabamento;
    }

    public function getMaterial() {
        return $this->material;
    }

    public function getCuba() {
        return $this->cuba;
    }

    public function getVista() {
        return $this->vista;
    }

    public function getSaia() {
        return $this->saia;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getVlEntrada() {
        return $this->vlEntrada;
    }

    public function getVlRestante() {
        return $this->vlRestante;
    }

    public function getVlTotal() {
        return $this->vlTotal;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    public function setDataEntrega($dataEntrega) {
        $this->dataEntrega = $dataEntrega;
    }

    public function setDataPedido($dataPedido) {
        $this->dataPedido = $dataPedido;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setAcabamento($acabamento) {
        $this->acabamento = $acabamento;
    }

    public function setMaterial($material) {
        $this->material = $material;
    }

    public function setCuba($cuba) {
        $this->cuba = $cuba;
    }

    public function setVista($vista) {
        $this->vista = $vista;
    }

    public function setSaia($saia) {
        $this->saia = $saia;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setVlEntrada($vlEntrada) {
        $this->vlEntrada = $vlEntrada;
    }

    public function setVlRestante($vlRestante) {
        $this->vlRestante = $vlRestante;
    }

    public function setVlTotal($vlTotal) {
        $this->vlTotal = $vlTotal;
    }
}
?>