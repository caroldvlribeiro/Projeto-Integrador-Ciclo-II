<?php
require_once '../config/database.php';
require_once '../models/Orcamento.php';
require_once '../models/Cliente.php';

class OrcamentoController {

    private $orcamentoModel;
    private $clienteModel;

    public function __construct() {
        global $conn;

        $this->orcamentoModel = new Orcamento($conn);
        $this->clienteModel   = new Cliente($conn);
    }

    public function criar() {

        $nmCliente  = $_POST['nmCliente'] ?? null;
        $dt_pedido  = $_POST['dtPedido'] ?? null;
        $valorTotal = $_POST['valorTotal'] ?? null;
        $descricao  = $_POST['descricao'] ?? null;
        $acabamento = $_POST['acabamento'] ?? null;
        $idPedra    = $_POST['idPedra'] ?? null;
        $status     = $_POST['status'] ?? 'Aberto';

        if (!$nmCliente || !$valorTotal) {
            echo json_encode(['erro' => 'Dados obrigatórios não informados']);
            return;
        }

        // 🔥 Evita duplicar cliente
        $idCliente = $this->clienteModel->getCd_Cliente($nmCliente);

        if (!$idCliente) {
            $this->clienteModel->setNome($nmCliente);
            $this->clienteModel->setTelefone($_POST['nrTelefone'] ?? null);
            $this->clienteModel->setEndereco($_POST['endereco'] ?? null);

            $this->clienteModel->salvar();
            $idCliente = $this->clienteModel->getCd_Cliente($nmCliente);
        }

        // Cria orçamento
        $this->orcamentoModel->setCliente($idCliente);
        $this->orcamentoModel->setDtPedido($dt_pedido);
        $this->orcamentoModel->setValor($valorTotal);
        $this->orcamentoModel->setDescricao($descricao);
        $this->orcamentoModel->setAcabamento($acabamento);
        $this->orcamentoModel->setPedra($idPedra);
        $this->orcamentoModel->setStatus($status);

        if ($this->orcamentoModel->salvar()) {
            echo json_encode(['sucesso' => 'Orçamento criado com sucesso']);
        } else {
            echo json_encode(['erro' => $this->orcamentoModel->getError()]);
        }
    }

    public function deletar() {
        header('Content-Type: application/json');

        $nmCliente = $_POST['nmCliente'] ?? null;
        $idCliente = $_POST['idCliente'] ?? null;

        if (!$nmCliente && !$idCliente) {
            echo json_encode(['erro' => 'Informe nome ou ID']);
            return;
        }

        if (!$idCliente) {
            $idCliente = $this->clienteModel->getCd_Cliente($nmCliente);
        }

        if (!$idCliente) {
            echo json_encode(['erro' => 'Cliente não encontrado']);
            return;
        }

        try {
            $this->clienteModel->beginTransaction();

            // 🔥 Deleta TODOS os orçamentos
            if (!$this->orcamentoModel->deletarPorCliente($idCliente)) {
                throw new Exception('Erro ao deletar orçamentos');
            }

            if (!$this->clienteModel->deletar($idCliente)) {
                throw new Exception('Erro ao deletar cliente');
            }

            $this->clienteModel->commit();

            echo json_encode(['sucesso' => 'Cliente deletado com sucesso']);

        } catch (Exception $e) {
            $this->clienteModel->rollBack();
            echo json_encode(['erro' => $e->getMessage()]);
        }
    }
}