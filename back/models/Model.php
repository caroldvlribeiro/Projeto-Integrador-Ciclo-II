<?php
require_once '../interfaces/ICrud.php';

abstract class Model implements ICrud {
    protected $_PDO;
    protected $_table;
    protected $_error;

    public function __construct(PDO $PDO, $table) {
        $this->_PDO = $PDO;
        $this->_table = $table;
    }

    public function getError() {
        return $this->_error;
    }

    // BUSCAR POR ID
    public function buscarPorId($id) {
        $sql = "SELECT * FROM {$this->_table} WHERE id = :id";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // DELETAR
    public function deletar($id) {
        $sql = "DELETE FROM {$this->_table} WHERE id = :id";
        $stmt = $this->_PDO->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // LISTAR TODOS
    public function listarTodos() {
        $sql = "SELECT * FROM {$this->_table}";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // VALIDAR CAMPOS
    public function validar($dados) {
        foreach ($dados as $dado) {
            if (empty($dado) && $dado !== "0") {
                $this->_error = "Preencha todos os campos!";
                return false;
            }
        }
        return true;
    }

    // EXECUTAR SQL (INSERT/UPDATE)
    public function executar($sql, $dados) {
        $stmt = $this->_PDO->prepare($sql);
        return $stmt->execute($dados);
    }

    // ABSTRACTS
    abstract public function salvar();
    abstract public function atualizar();
}