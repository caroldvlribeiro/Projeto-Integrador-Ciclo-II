<?php
require_once __DIR__ . '/../../../back/controller/AuthController.php';
require_once __DIR__ . '/../../../back/config/database.php';
require_once __DIR__ . '/../../../back/controller/ProdutoController.php';
require_once __DIR__ . '/../../../back/controller/CategoriaProdutoController.php';

$controller  = new ProdutoController($pdo);
$catCtrl     = new CategoriaProdutoController($pdo);
$mensagem    = null;
$tipoMensagem = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    if ($acao === 'criar') {
        $idCat   = (int)($_POST['id_categoria'] ?? 0);
        $nome    = trim($_POST['nome'] ?? '');
        $desc    = trim($_POST['descricao'] ?? '');
        $valor   = (float)str_replace(',', '.', $_POST['valor'] ?? '0');
        if ($controller->salvar($idCat, $nome, $desc, $valor)) {
            $mensagem = 'Produto cadastrado com sucesso.';
            $tipoMensagem = 'success';
        } else {
            $mensagem = 'Erro ao cadastrar: ' . ($controller->getErro() ?? 'verifique os dados.');
            $tipoMensagem = 'error';
        }
    } elseif ($acao === 'editar') {
        $id      = (int)($_POST['id'] ?? 0);
        $idCat   = (int)($_POST['id_categoria'] ?? 0);
        $nome    = trim($_POST['nome'] ?? '');
        $desc    = trim($_POST['descricao'] ?? '');
        $valor   = (float)str_replace(',', '.', $_POST['valor'] ?? '0');
        if ($controller->atualizar($id, $idCat, $nome, $desc, $valor)) {
            $mensagem = 'Produto atualizado.';
            $tipoMensagem = 'success';
        } else {
            $mensagem = 'Erro ao atualizar: ' . ($controller->getErro() ?? 'verifique os dados.');
            $tipoMensagem = 'error';
        }
    } elseif ($acao === 'deletar') {
        $id = (int)($_POST['id'] ?? 0);
        if ($controller->deletar($id)) {
            $mensagem = 'Produto removido.';
            $tipoMensagem = 'success';
        } else {
            $mensagem = 'Erro ao remover.';
            $tipoMensagem = 'error';
        }
    }
}

$produtos   = $controller->listarComCategoria($pdo);
$categorias = $catCtrl->listar();
