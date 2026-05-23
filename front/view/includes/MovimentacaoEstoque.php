<?php
require_once __DIR__ . '/../../../back/controller/AuthController.php';
require_once __DIR__ . '/../../../back/config/database.php';
require_once __DIR__ . '/../../../back/controller/MovimentacaoEstoqueController.php';

$controller = new MovimentacaoEstoqueController($pdo);
$mensagem = null;
$tipoMensagem = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    if ($acao === 'criar') {
        $id_produto = (int)($_POST['id_produto'] ?? 0);
        $tipo = trim($_POST['tipo'] ?? '');
        $quantidade = (int)($_POST['quantidade'] ?? 0);

        if ($controller->registrar($id_produto, $tipo, $quantidade)) {
            $mensagem = 'Movimentação registrada com sucesso.';
            $tipoMensagem = 'success';
        } else {
            $mensagem = $controller->getErro() ?? 'Erro ao registrar movimentação.';
            $tipoMensagem = 'error';
        }
    }
}

$movimentacoes = $controller->listar();
