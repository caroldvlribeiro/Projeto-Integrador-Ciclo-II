<?php
require_once '../interfaces/ICrud.php';
abstract class Model implements ICrud
{
    protected $_PDO;
    protected $_table;
    protected $_error;

    public function __construct(PDO $PDO, $table)
    {
        $this->_PDO = $PDO;
        $this->_table = $table;
    }
    public function getError()
    {
        return $this->_error;
    }
    //buscar item na tabela por id - Ajustado para buscarPorId conforme interface
    public function buscarPorId(int $id): mixed
    {
        $select = $this->_PDO->prepare("SELECT * FROM {$this->_table} where id = :id");
        $select->bindParam(':id', $id);
        $select->execute();
        return $select->fetch(PDO::FETCH_ASSOC);
    }
    //deletar - Ajustado parâmetro conforme interface
    public function deletar(int $id): bool
    {
        $delete = $this->_PDO->prepare("DELETE FROM {$this->_table} where id = :id");
        $delete->bindParam(':id', $id);
        return $delete->execute();
    }
    //listar todos os itens da tabela - Ajustado para listarTodos conforme interface
    public function listarTodos(): array
    {
        $select = $this->_PDO->prepare("SELECT * FROM {$this->_table}");
        $select->execute();
        return $select->fetchAll(PDO::FETCH_ASSOC);
    }
    //validar se os campos estão preenchidos
    public function validar($dados)
    {
        foreach ($dados as $dado) {
            if (empty($dado)) {
                $this->_error = "Preencha todos os campos!";
                return false;
            }
        }
        return true;
    }
    public function executar($sql, $dados)
    {
        $insert = $this->_PDO->prepare($sql);
        foreach ($dados as $key => $dado) {
            $insert->bindValue(":$key", $dado);
        }
        return $insert->execute();
    }

    abstract public function salvar(): bool;
    abstract public function atualizar(int $id): bool;
}

?>