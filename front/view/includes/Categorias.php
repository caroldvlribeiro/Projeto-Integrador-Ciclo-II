<?php
require_once __DIR__ . '/../../../back/controller/AuthController.php';
require_once __DIR__ . '/../../../back/config/database.php';
require_once __DIR__ . '/../../../back/controller/CategoriaProdutoController.php';

$controller = new CategoriaProdutoController($pdo);
$mensagem = null;
$tipoMensagem = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    if ($acao === 'criar') {
        $nome = trim($_POST['nome'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        if ($controller->salvar($nome, $descricao)) {
            $mensagem = 'Categoria cadastrada com sucesso.';
            $tipoMensagem = 'success';
        } else {
            $mensagem = 'Erro ao cadastrar: ' . ($controller->getErro() ?? 'verifique os dados.');
            $tipoMensagem = 'error';
        }
    } elseif ($acao === 'editar') {
        $id = (int)($_POST['id'] ?? 0);
        $nome = trim($_POST['nome'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        if ($controller->atualizar($id, $nome, $descricao)) {
            $mensagem = 'Categoria atualizada.';
            $tipoMensagem = 'success';
        } else {
            $mensagem = 'Erro ao atualizar: ' . ($controller->getErro() ?? 'verifique os dados.');
            $tipoMensagem = 'error';
        }
    } elseif ($acao === 'deletar') {
        $id = (int)($_POST['id'] ?? 0);
        if ($controller->deletar($id)) {
            $mensagem = 'Categoria removida.';
            $tipoMensagem = 'success';
        } else {
            $mensagem = 'Erro ao remover.';
            $tipoMensagem = 'error';
        }
    }
}

$categorias = $controller->listar();