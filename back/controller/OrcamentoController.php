<?php
require_once '../config/database.php';
require_once '../models/Orcamento.php';
require_once '../models/Cliente.php';
require_once '../models/Pagamento.php';
require_once '../models/Venda.php';
$acao = $_GET['acao'] ?? null;

$orcamentoModel = new Orcamento($pdo);  
$clienteModel = new Cliente($pdo);
$pagamentoModel = new Pagamento($pdo);
$vendaModel = new Venda($pdo);
 

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
    $Nmcliente = $_POST['nm_cliente'];
    $telefone = $_POST['cd_telefone'];
    $endereco = $_POST['nm_endereco'];
    $dataPedido = $_POST['dt_pedido'];
    $descricao = $_POST['ds_descricao'];
    $acabamento = $_POST['acabamento'];
    $saia = $_POST['saia'] ?: null;
    $vista = $_POST['vista'] ?: null;
    $cuba = $_POST['cuba'] ?: null;
    $pedra = $_POST['id_pedra'];
    $dtEntrega = $_POST['dt_entrega'];
    $status = $_POST['status'];
    $vlTotal = $_POST['vl_total'];
    $dtPagamentoEntrada = $_POST['dt_pagamento_entrada'];
    $vlEntrada = $_POST['vl_entrada'];
    $dtPagamentoSaida = $_POST['dt_pagamento_saida'] ?: null;
    $vlSaida = $_POST['vl_saida'] ?: null;
    $vendedor = $_POST['vendedor'];

    try{
    // Criar cliente
    //fazer uma condição para caso já exista um cliente com esse nm
    $cdCliente = $clienteModel->getCd_Cliente($telefone);
    if(!$cdCliente){
    $clienteModel->setNome($Nmcliente);    
    $clienteModel->setTelefone($telefone);
    $clienteModel->setEndereco($endereco);
    $clienteModel->salvar();
    $cdCliente = $clienteModel->getCd_Cliente($telefone);
    }
    
    // Criar orçamento
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
    $cdOrcamento = $orcamentoModel->getCd_Orcamento($cdCliente);
    // Criar pagamento
    $pagamentoModel->setCdOrcamento($cdOrcamento);
    $pagamentoModel->setEntrada($vlEntrada, $dtPagamentoEntrada);
    $pagamentoModel->setSaida($vlSaida, $dtPagamentoSaida);
    $pagamentoModel->salvar();
    // Criar venda
    $vendaModel->setOrcamento($cdOrcamento);
    $vendaModel->setVendedor($vendedor);
    $vendaModel->setValorTotal($vlTotal);
    $vendaModel->setDataVenda($dataPedido);
    $vendaModel->salvar();
    header('Location: ../../front/view/Orcamentos.php');
exit;
    }
    catch (Exception $e) {

        echo "Erro ao salvar: " . $e->getMessage();

    }
    

}
function atualizar($orcamentoModel, $pagamentoModel)
{
    // dados do form:
    $idOrcamento = $_POST['idOrcamento'];
    $status = $_POST['status'];
    $dtPagamentoSaida = $_POST['dtPagamentoSaida'];
    $vlSaida = $_POST['valorSaida'];
try{
    // Atualizar orçamento
    $orcamentoModel->setStatus($status);
    $orcamentoModel->atualizar($idOrcamento);
    // Atualizar pagamento
    $pagamentoModel->setOrcamento($idOrcamento);
    $pagamentoModel->setSaida($vlSaida,$dtPagamentoSaida);
    $pagamentoModel->atualizar($idOrcamento);
    header('Location: ../../front/view/Orcamentos.php');
exit;
    }
catch (Exception $e) {

        echo "Erro ao atualizar: " . $e->getMessage();

    }

}
function deletar($orcamentoModel, $vendaModel, $pagamentoModel)
{
    try{
    $idOrcamento = $_GET['idOrcamento'];
    $orcamentoModel->deletar($idOrcamento);
    header('Location: ../../front/view/Orcamentos.php');
exit;
    
    }catch (Exception $e) {

        echo "Erro ao deletar: " . $e->getMessage();

    }

}
function buscarPorNome($orcamentoModel){
    $busca = $_GET['busca'] ?? '';
    if (!empty($busca)) {

    $orcamentos = $orcamentoModel->buscarPorNome($busca);

} else {

    $orcamentos = $orcamentoModel->listarOrcamentoModal();
}
 return $orcamentos;
}
