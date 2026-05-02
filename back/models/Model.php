<?php
require_once '../interfaces/ICrud.php';

/**
 * Classe Base Model
 * Centraliza a conexão com o banco e operações genéricas de CRUD.
 */
abstract class Model implements ICrud
{
    protected $_PDO;   // Objeto de conexão PDO
    protected $_table; // Nome da tabela no banco de dados
    protected $_error; // Armazena mensagens de erro

    public function __construct(PDO $PDO, $table)
    {
        $this->_PDO = $PDO;
        $this->_table = $table;
    }

    // Retorna o último erro ocorrido
    public function getError()
    {
        return $this->_error;
    }

    /**
     * Mapeia o nome da Chave Primária conforme o SQL do projeto.
     */
    protected function getPrimaryKeyName()
    {
        $pks = [
            'cliente' => 'cd_cliente',
            'usuario' => 'id_usuario',
            'vendedor' => 'id_vendedor',
            'pedra' => 'id_pedra',
            'produto' => 'id_produto',
            'orcamento' => 'id_orcamento',
            'agenda' => 'id_agenda',
            'pagamento' => 'id_pagamento',
            'venda' => 'id_venda'
        ];
        return $pks[$this->_table] ?? 'id';
    }

    // Busca um registro pelo seu ID específico
    public function buscarPorId(int $id): mixed
    {
        $pk = $this->getPrimaryKeyName();
        $select = $this->_PDO->prepare("SELECT * FROM {$this->_table} WHERE {$pk} = :id");
        $select->bindParam(':id', $id, PDO::PARAM_INT);
        $select->execute();
        return $select->fetch(PDO::FETCH_ASSOC);
    }

    // Deleta um registro pelo seu ID específico
    public function deletar(int $id): bool
    {
        $pk = $this->getPrimaryKeyName();
        $delete = $this->_PDO->prepare("DELETE FROM {$this->_table} WHERE {$pk} = :id");
        $delete->bindParam(':id', $id, PDO::PARAM_INT);
        return $delete->execute();
    }

    // Lista todos os registros da tabela
    public function listarTodos(): array
    {
        $select = $this->_PDO->prepare("SELECT * FROM {$this->_table}");
        $select->execute();
        return $select->fetchAll(PDO::FETCH_ASSOC);
    }

    // Valida se os campos obrigatórios não estão vazios
    protected function validar(array $dados): bool
    {
        foreach ($dados as $key => $valor) {
            if ($valor === null || $valor === '') {
                $this->_error = "O campo {$key} deve ser preenchido!";
                return false;
            }
        }
        return true;
    }

    // Executa comandos SQL (Insert/Update) com segurança (Prepared Statements)
    public function executar($sql, $dados)
    {
        try {
            $stmt = $this->_PDO->prepare($sql);
            foreach ($dados as $key => $valor) {
                $stmt->bindValue(":$key", $valor);
            }
            return $stmt->execute();
        } catch (PDOException $e) {
            $this->_error = "Erro no banco: " . $e->getMessage();
            return false;
        }
    }

    abstract public function salvar(): bool;
    abstract public function atualizar(int $id): bool;
}

?>