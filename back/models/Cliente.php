<?php
require_once 'Pessoa.php';

/**
 * Model Cliente
 * Gerencia os dados da tabela 'cliente'.
 */
class Cliente extends Pessoa
{
    protected $cd_cliente;
    protected $nm_endereco;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo, 'cliente');
    }

    // Mapeamento para o campo 'nm_endereco' do banco
    public function setEndereco($endereco)
    {
        $this->nm_endereco = $endereco;
    }
    public function getEndereco()
    {
        return $this->nm_endereco;
    }

    // Retorna resumo do cliente
    public function getPerfil(): string
    {
        return "Cliente: {$this->nome} | Tel: {$this->telefone} | End: {$this->nm_endereco} | ID: {$this->getCd_Cliente($this->nome)}";
    }

    //pegar o cd do cliente a partir do nome
    public function getCd_Cliente($nm_cliente)
    {
        $sql = "SELECT cd_cliente FROM cliente WHERE nm_cliente = :nm_cliente";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute(['nm_cliente' => $nm_cliente]);
        return $stmt->fetchColumn();
    }

    /**
     * Busca todos os orçamentos vinculados a este cliente.
     */
    public function buscarOrcamentos()
    {
        $sql = "SELECT * FROM orcamento WHERE cd_cliente = :id";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute(['id' => $this->cd_cliente]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Insere um novo cliente no banco
    public function salvar(): bool
    {
        $dados = [
            'nm_cliente' => $this->nome,
            'cd_telefone' => $this->telefone,
            'nm_endereco' => $this->nm_endereco
        ];

        if ($this->validar($dados)) {
            $sql = "INSERT INTO {$this->_table} (nm_cliente, cd_telefone, nm_endereco) 
                    VALUES (:nm_cliente, :cd_telefone, :nm_endereco)";
            return $this->executar($sql, $dados);
        }
        return false;
    }

    // Atualiza os dados de um cliente existente
    public function atualizar(int $id): bool
    {
        $dados = [
            'id' => $id,
            'nm_cliente' => $this->nome,
            'cd_telefone' => $this->telefone,
            'nm_endereco' => $this->nm_endereco
        ];

        if ($this->validar($dados)) {
            $sql = "UPDATE {$this->_table} SET 
                    nm_cliente = :nm_cliente, 
                    cd_telefone = :cd_telefone, 
                    nm_endereco = :nm_endereco 
                    WHERE cd_cliente = :id";
            return $this->executar($sql, $dados);
        }
        return false;
    }
     public function deletar($cd_cliente): bool {
    try {
        $sql = "DELETE FROM cliente WHERE cd_cliente = :id";
         $stmt = $this->_PDO->prepare($sql);
        $stmt->execute(['id' => $cd_cliente]);
        return $stmt->execute();
        
    } catch (PDOException $e) {
        echo "Erro ao deletar: " . $e->getMessage();
        return false;
    }}

    public function beginTransaction() {
    return $this->_PDO->beginTransaction();
}

public function commit() {
    return $this->_PDO->commit();
}

public function rollBack() {
    return $this->_PDO->rollBack();
}
}

?>