<?php

header('Content-Type: application/json');

require_once '../config/database.php';
require_once '../models/Orcamento.php';
require_once '../models/Cliente.php';
require_once '../models/Pagamento.php';
require_once '../models/Venda.php';
require_once '../models/Agenda.php';

$acao = $_GET['acao'] ?? null;

$orcamentoModel = new Orcamento($pdo);
$clienteModel = new Cliente($pdo);
$pagamentoModel = new Pagamento($pdo);
$vendaModel = new Venda($pdo);
$agendamentoModel = new Agenda($pdo);

switch ($acao) {

    case 'criar':

        criar(
            $orcamentoModel,
            $clienteModel,
            $pagamentoModel,
            $vendaModel
        );

        break;

    case 'atualizar':

        atualizar(
            $orcamentoModel,
            $pagamentoModel
        );

        break;

    case 'deletar':

        deletar(
            $orcamentoModel,
            $vendaModel,
            $pagamentoModel
        );

        break;
}

/*
|--------------------------------------------------------------------------
| CRIAR
|--------------------------------------------------------------------------
*/

function criar(
    $orcamentoModel,
    $clienteModel,
    $pagamentoModel,
    $vendaModel
)
{

    /*
    |--------------------------------------------------------------------------
    | DADOS DO FORMULÁRIO
    |--------------------------------------------------------------------------
    */

    $nmCliente = $_POST['nmCliente'] ?? null;
    $telefone = $_POST['telefone'] ?? null;
    $endereco = $_POST['endereco'] ?? null;

    $dataPedido = $_POST['dtPedido'] ?? null;
    $descricao = $_POST['descricao'] ?? null;
    $saia = $_POST['saia'] ?? null;
    $acabamento = $_POST['acabamento'] ?? null;
    $vista = $_POST['vista'] ?? null;
    $cuba = $_POST['cuba'] ?? null;
    $pedra = $_POST['pedra'] ?? null;
    $dtEntrega = $_POST['dtEntrega'] ?? null;
    $status = $_POST['status'] ?? null;
    $vlTotal = $_POST['valorTotal'] ?? null;

    $dtPagamentoEntrada =
        $_POST['dtPagamentoEntrada'] ?? null;

    $vlEntrada =
        $_POST['valorEntrada'] ?? null;

    $dtPagamentoSaida =
        $_POST['dtPagamentoSaida'] ?? null;

    $vlSaida =
        $_POST['valorSaida'] ?? null;

    $vendedor = $_POST['vendedor'] ?? null;

    try {

        /*
        |--------------------------------------------------------------------------
        | CLIENTE
        |--------------------------------------------------------------------------
        */

        $clienteModel->setNome($nmCliente);

        $clienteModel->setTelefone($telefone);

        $clienteModel->setEndereco($endereco);

        $clienteModel->salvar();

        $cdCliente =
            $clienteModel->getCd_Cliente($telefone);

        /*
        |--------------------------------------------------------------------------
        | ORÇAMENTO
        |--------------------------------------------------------------------------
        */

        $orcamentoModel->setCliente($cdCliente);

        $orcamentoModel->setDtPedido($dataPedido);

        $orcamentoModel->setDescricao($descricao);

        $orcamentoModel->setSaia($saia);

        $orcamentoModel->setAcabamento($acabamento);

        $orcamentoModel->setVista($vista);

        $orcamentoModel->setCuba($cuba);

        $orcamentoModel->setPedra($pedra);

        $orcamentoModel->setDtEntrega($dtEntrega);

        $orcamentoModel->setStatus($status);

        $orcamentoModel->setValor($vlTotal);

        $orcamentoModel->salvar();

        $cdOrcamento =
            $orcamentoModel->getCd_Orcamento($cdCliente);

        /*
        |--------------------------------------------------------------------------
        | PAGAMENTO
        |--------------------------------------------------------------------------
        */

        $pagamentoModel->setCdOrcamento($cdOrcamento);

        $pagamentoModel->setDtPagamentoEntrada(
            $dtPagamentoEntrada
        );

        $pagamentoModel->setVlEntrada($vlEntrada);

        $pagamentoModel->setDtPagamentoSaida(
            $dtPagamentoSaida
        );

        $pagamentoModel->setVlSaida($vlSaida);

        $pagamentoModel->salvar();

        /*
        |--------------------------------------------------------------------------
        | VENDA
        |--------------------------------------------------------------------------
        */

        $vendaModel->setidOrcamento($cdOrcamento);

        $vendaModel->setVendedor($vendedor);

        $vendaModel->salvar();

        echo json_encode([
            'sucesso' => true,
            'mensagem' => 'Orçamento criado com sucesso'
        ]);

    } catch (Exception $e) {

        echo json_encode([
            'sucesso' => false,
            'erro' => $e->getMessage()
        ]);
    }
}

/*
|--------------------------------------------------------------------------
| ATUALIZAR
|--------------------------------------------------------------------------
*/

function atualizar(
    $orcamentoModel,
    $pagamentoModel
)
{

    $idOrcamento = $_POST['idOrcamento'] ?? null;

    $status = $_POST['status'] ?? null;

    $vlTotal = $_POST['valorTotal'] ?? null;

    $dtPagamentoEntrada =
        $_POST['dtPagamentoEntrada'] ?? null;

    $vlEntrada =
        $_POST['valorEntrada'] ?? null;

    $dtPagamentoSaida =
        $_POST['dtPagamentoSaida'] ?? null;

    $vlSaida =
        $_POST['valorSaida'] ?? null;

    try {

        /*
        |--------------------------------------------------------------------------
        | ORÇAMENTO
        |--------------------------------------------------------------------------
        */

        $orcamentoModel->setStatus($status);

        $orcamentoModel->setVlTotal($vlTotal);

        $orcamentoModel->atualizar($idOrcamento);

        /*
        |--------------------------------------------------------------------------
        | PAGAMENTO
        |--------------------------------------------------------------------------
        */

        $pagamentoModel->setDtPagamentoEntrada(
            $dtPagamentoEntrada
        );

        $pagamentoModel->setVlEntrada($vlEntrada);

        $pagamentoModel->setDtPagamentoSaida(
            $dtPagamentoSaida
        );

        $pagamentoModel->setVlSaida($vlSaida);

        $pagamentoModel->atualizarPorOrcamento(
            $idOrcamento
        );

        echo json_encode([
            'sucesso' => true,
            'mensagem' => 'Orçamento atualizado'
        ]);

    } catch (Exception $e) {

        echo json_encode([
            'sucesso' => false,
            'erro' => $e->getMessage()
        ]);
    }
}

/*
|--------------------------------------------------------------------------
| DELETAR
|--------------------------------------------------------------------------
*/

function deletar(
    $orcamentoModel,
    $vendaModel,
    $pagamentoModel
)
{

    try {

        $idOrcamento =
            $_GET['idOrcamento'] ?? null;

        $vendaModel->deletar($idOrcamento);

        $pagamentoModel->deletar($idOrcamento);

        $orcamentoModel->deletar($idOrcamento);

        echo json_encode([
            'sucesso' => true,
            'mensagem' => 'Orçamento deletado'
        ]);

    } catch (Exception $e) {

        echo json_encode([
            'sucesso' => false,
            'erro' => $e->getMessage()
        ]);
    }
}

/*
|--------------------------------------------------------------------------
| BUSCAR
|--------------------------------------------------------------------------
*/

function buscar(
    $orcamentoModel,
    $clienteModel
)
{

    $cdCliente = $_GET['cdCliente'] ?? null;

    return $clienteModel->buscarOrcamentos(
        $cdCliente
    );
}

/*
|--------------------------------------------------------------------------
| LISTAR
|--------------------------------------------------------------------------
*/

function listar($orcamentoModel)
{
    return $orcamentoModel->listarTodos();
}