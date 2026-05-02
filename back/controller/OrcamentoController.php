<?php
require_once '../config/database.php';
require_once '../models/Orcamento.php';

class OrcamentoController {

    private $orcamentoModel;

    public function __construct() {
        global $conn;
        $this->orcamentoModel = new Orcamento($conn);
    }

    public function criar() {
        // Recebe dados do POST
        $idCliente = $_POST['idCliente'] ?? null;
        $dt_pedido = $_POST['dtPedido'] ?? null;
        $valorTotal = $_POST['valorTotal'] ?? null;
        $descricao = $_POST['descricao'] ?? null;
        $acabamento = $_POST['acabamento'] ?? null;
        $idPedra = $_POST['idPedra'] ?? null;
        $status = $_POST['status'] ?? 'Aberto';

        // Validação básica
        if (!$idCliente || !$valorTotal) {
            echo json_encode(['erro' => 'Dados incompletos: idCliente e valorTotal são obrigatórios']);
            return;
        }

        // Define os valores no model
        $this->orcamentoModel->setCliente($idCliente);
        $this->orcamentoModel->setDtPedido($dt_pedido);
        $this->orcamentoModel->setValor($valorTotal);
        $this->orcamentoModel->setDescricao($descricao);
        $this->orcamentoModel->setAcabamento($acabamento);
        $this->orcamentoModel->setPedra($idPedra);
        $this->orcamentoModel->setStatus($status);

        // Salva no banco
        if ($this->orcamentoModel->salvar()) {
            echo json_encode(['sucesso' => 'Orçamento criado com sucesso']);
        } else {
            echo json_encode(['erro' => 'Erro ao criar orçamento: ' . $this->orcamentoModel->getError()]);
        }
    }

    public function listar() {
        $orcamentos = $this->orcamentoModel->listarTodos();
        echo json_encode($orcamentos);
    }

    public function buscarPorId() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo json_encode(['erro' => 'ID não fornecido']);
            return;
        }

        $orcamento = $this->orcamentoModel->buscarPorId($id);
        if ($orcamento) {
            echo json_encode($orcamento);
        } else {
            echo json_encode(['erro' => 'Orçamento não encontrado']);
        }
    }

    public function atualizar() {
        $id = $_POST['id'] ?? null;
        $valorTotal = $_POST['valorTotal'] ?? null;
        $descricao = $_POST['descricao'] ?? null;
        $status = $_POST['status'] ?? null;

        if (!$id) {
            echo json_encode(['erro' => 'ID do orçamento é obrigatório']);
            return;
        }

        // Define os valores no model
        if ($valorTotal !== null) $this->orcamentoModel->setValor($valorTotal);
        if ($descricao !== null) $this->orcamentoModel->setDescricao($descricao);
        if ($status !== null) $this->orcamentoModel->setStatus($status);

        // Atualiza no banco
        if ($this->orcamentoModel->atualizar($id)) {
            echo json_encode(['sucesso' => 'Orçamento atualizado com sucesso']);
        } else {
            echo json_encode(['erro' => 'Erro ao atualizar orçamento: ' . $this->orcamentoModel->getError()]);
        }
    }

    public function deletar() {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            echo json_encode(['erro' => 'ID do orçamento é obrigatório']);
            return;
        }

        if ($this->orcamentoModel->deletar($id)) {
            echo json_encode(['sucesso' => 'Orçamento deletado com sucesso']);
        } else {
            echo json_encode(['erro' => 'Erro ao deletar orçamento']);
        }
    }
}