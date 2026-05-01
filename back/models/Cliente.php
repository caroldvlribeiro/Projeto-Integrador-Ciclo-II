<?php
require_once 'Model.php';

class Cliente extends Model {

    private $cdCliente;
    private $nmCliente;
    private $cdTelefone;
    private $nmEndereco;

    public function __construct(PDO $pdo) {
        parent::__construct($pdo, 'clientes');
    }

    // GETTERS E SETTERS
    public function getCdCliente() {
        return $this->cdCliente;
    }

    public function setCdCliente($cdCliente) {
        $this->cdCliente = $cdCliente;
    }

    public function getNmCliente() {
        return $this->nmCliente;
    }

    public function setNmCliente($nmCliente) {
        $this->nmCliente = $nmCliente;
    }

    public function getCdTelefone() {
        return $this->cdTelefone;
    }

    public function setCdTelefone($cdTelefone) {
        $this->cdTelefone = $cdTelefone;
    }

    public function getNmEndereco() {
        return $this->nmEndereco;
    }

    public function setNmEndereco($nmEndereco) {
        $this->nmEndereco = $nmEndereco;
    }

    // MÉTODOS DO DIAGRAMA

    public function getPerfil() {
        return "Cliente: {$this->nmCliente} | Tel: {$this->cdTelefone}";
    }

    public function buscarOrcamentos() {
        $sql = "SELECT * FROM orcamentos WHERE cliente_id = :id";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute(['id' => $this->cdCliente]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarAgendamentos() {
        $sql = "SELECT * FROM agendamentos WHERE cliente_id = :id";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute(['id' => $this->cdCliente]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function salvar() {
        $dados = [
            'nome' => $this->nmCliente,
            'telefone' => $this->cdTelefone,
            'endereco' => $this->nmEndereco
        ];

        $sql = "INSERT INTO {$this->_table} (nome, telefone, endereco)
                VALUES (:nome, :telefone, :endereco)";

        return $this->executar($sql, $dados);
    }

    public function atualizar() {
        if (!$this->cdCliente) {
            throw new Exception("ID do cliente não definido");
        }

        $dados = [
            'id' => $this->cdCliente,
            'nome' => $this->nmCliente,
            'telefone' => $this->cdTelefone,
            'endereco' => $this->nmEndereco
        ];

        $sql = "UPDATE {$this->_table}
                SET nome = :nome, telefone = :telefone, endereco = :endereco
                WHERE id = :id";

        return $this->executar($sql, $dados);
    }
}