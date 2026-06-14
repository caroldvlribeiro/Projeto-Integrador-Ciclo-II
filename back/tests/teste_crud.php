<?php
require_once '../controller/OrcamentoController.php';

$controller = new OrcamentoController();

// Define o tipo de resposta
header('Content-Type: application/json');

// Roteamento simples
$acao = $_GET['acao'] ?? null;

switch ($acao) {

    case 'criar':
        
        $controller->criar();
        break;
        
    case 'deletar':
    $controller->deletar();
    break;


    default:
        echo json_encode([
            'erro' => 'Ação inválida',
            'acoes_disponiveis' => [
                '?acao=criar',
                '?acao=deletar'
            ]
        ]);
}