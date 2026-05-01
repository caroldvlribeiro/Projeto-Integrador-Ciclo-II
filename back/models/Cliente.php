<?php
require_once 'Pessoa.php';

class Cliente extends Pessoa
{

    private $cdCliente;
    private $nmEndereco;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo, 'clientes');
    }

    // GETTERS E SETTERS
    public function getCdCliente()
    {
        return $this->cdCliente;
    }

    public function setCdCliente($cdCliente)
    {
        $this->cdCliente = $cdCliente;
    }

    public function getNmEndereco()
    {
        return $this->nmEndereco;
    }

    public function setNmEndereco($nmEndereco)
    {
        $this->nmEndereco = $nmEndereco;
    }

    // MÉTODOS DO DIAGRAMA

    public function getPerfil(): string
    {
        return "Cliente: {$this->nome} | Tel: {$this->telefone}";
    }

    public function buscarOrcamentos()
    {
        $sql = "SELECT * FROM orcamentos WHERE cliente_id = :id";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute(['id' => $this->cdCliente]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarAgendamentos()
    {
        $sql = "SELECT * FROM agendamentos WHERE cliente_id = :id";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute(['id' => $this->cdCliente]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function salvar(): bool
    {
        $dados = [
            'nome' => $this->nome,
            'telefone' => $this->telefone,
            'endereco' => $this->nmEndereco
        ];

        if ($this->validar($dados)) {
            $sql = "INSERT INTO {$this->_table} (nome, telefone, endereco)
                    VALUES (:nome, :telefone, :endereco)";
            return $this->executar($sql, $dados);
        }
        return false;
    }

    public function atualizar(int $id): bool
    {
        $dados = [
            'id' => $id,
            'nome' => $this->nome,
            'telefone' => $this->telefone,
            'endereco' => $this->nmEndereco
        ];

        if ($this->validar($dados)) {
            $sql = "UPDATE {$this->_table}
                    SET nome = :nome, telefone = :telefone, endereco = :endereco
                    WHERE id = :id";
            return $this->executar($sql, $dados);
        }
        return false;
    }
}

?>