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
        criar($orcamentoModel, $clienteModel, $pagamentoModel, $vendaModel);
        break;
    case 'atualizar':
        atualizar($orcamentoModel,$pagamentoModel);

        break;
    // Outros casos para editar, excluir, etc.
    case 'deletar':
        deletar($orcamentoModel, $vendaModel, $pagamentoModel);
        break;
}

// Função para criar um novo orçamento
function criar($orcamentoModel, $clienteModel, $pagamentoModel, $vendaModel)
{

    // dados do form:
    $Nmcliente = $_POST['nmCliente'];    
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    $dataPedido = $_POST['dtPedido'];
    $descricao = $_POST['descricao'];
    $saia = $_POST['saia'];
    $acabamento = $_POST['acabamento'];
    $vista = $_POST['vista'];
    $cuba = $_POST['cuba'];
    $pedra = $_POST['pedra'];
    $dtEntrega = $_POST['dtEntrega'];
    $status = $_POST['status'];
    $vlTotal = $_POST['valorTotal'];
    $dtPagamentoEntrada = $_POST['dtPagamentoEntrada'];
    $vlEntrada = $_POST['valorEntrada'];
    $dtPagamentoSaida = $_POST['dtPagamentoSaida'];
    $vlSaida = $_POST['valorSaida'];
    $vendedor = $_POST['vendedor'];

    try{
    // Criar cliente
    $clienteModel->setNmCliente($Nmcliente);    
    $clienteModel->setTelefone($telefone);
    $clienteModel->setEndereco($endereco);
    $clienteModel->salvar();
    $cdCliente = $clienteModel->getCd_Cliente($telefone);
    // Criar orçamento
    $orcamentoModel->setCdCliente($cdCliente);
    $orcamentoModel->setDtPedido($dataPedido);
    $orcamentoModel->setDsDescricao($descricao);
    $orcamentoModel->setSaia($saia);
    $orcamentoModel->setAcabamento($acabamento);
    $orcamentoModel->setVista($vista);
    $orcamentoModel->setCuba($cuba);
    $orcamentoModel->setIdPedra($pedra);
    $orcamentoModel->setDtEntrega($dtEntrega);
    $orcamentoModel->setStatus($status);
    $orcamentoModel->setVlTotal($vlTotal);
    $orcamentoModel->salvar();
    $cdOrcamento = $orcamentoModel->getCd_Orcamento($cdCliente);
    // Criar pagamento
    $pagamentoModel->setCdOrcamento($cdOrcamento);
    $pagamentoModel->setDtPagamentoEntrada($dtPagamentoEntrada);
    $pagamentoModel->setVlEntrada($vlEntrada);
    $pagamentoModel->setDtPagamentoSaida($dtPagamentoSaida);
    $pagamentoModel->setVlSaida($vlSaida);
    $pagamentoModel->salvar();
    // Criar venda
    $vendaModel->setCdOrcamento($cdOrcamento);
    $vendaModel->setVendedor($vendedor);
    $vendaModel->salvar();}
    catch (Exception $e) {

        echo "Erro ao salvar: " . $e->getMessage();

    }

}
function atualizar($orcamentoModel, $pagamentoModel)
{
    // dados do form:
    $idOrcamento = $_POST['idOrcamento'];
    $status = $_POST['status'];
    $vlTotal = $_POST['valorTotal'];
    $dtPagamentoEntrada = $_POST['dtPagamentoEntrada'];
    $vlEntrada = $_POST['valorEntrada'];
    $dtPagamentoSaida = $_POST['dtPagamentoSaida'];
    $vlSaida = $_POST['valorSaida'];
try{
    // Atualizar orçamento
    $orcamentoModel->setStatus($status);
    $orcamentoModel->setVlTotal($vlTotal);
    $orcamentoModel->atualizar($idOrcamento);
    // Atualizar pagamento
    $pagamentoModel->setDtPagamentoEntrada($dtPagamentoEntrada);
    $pagamentoModel->setVlEntrada($vlEntrada);
    $pagamentoModel->setDtPagamentoSaida($dtPagamentoSaida);
    $pagamentoModel->setVlSaida($vlSaida);
    $pagamentoModel->atualizarPorOrcamento($idOrcamento);}
catch (Exception $e) {

        echo "Erro ao atualizar: " . $e->getMessage();

    }

}
function deletar($orcamentoModel, $vendaModel, $pagamentoModel)
{
    try{
    $idOrcamento = $_GET['idOrcamento'];
    $vendaModel->deletar($idOrcamento);
    $pagamentoModel->deletar($idOrcamento);
    $orcamentoModel->deletar($idOrcamento);
    }catch (Exception $e) {

        echo "Erro ao deletar: " . $e->getMessage();

    }
}
function buscar($orcamentoModel, $clienteModel)
{
    $cdCliente = $_GET['cdCliente'];
    $orcamentos = $clienteModel->buscarOrcamentos($cdCliente);
    // Retornar ou exibir os orçamentos encontrados
    return $orcamentos;
}
function listar($orcamentoModel)
{
    $orcamentos = $orcamentoModel->listarTodos();
    // Retornar ou exibir a lista de orçamentos
    return $orcamentos;
}