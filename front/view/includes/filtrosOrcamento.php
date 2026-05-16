<?php 
require_once '../../back/config/database.php';
require_once '../../back/models/Orcamento.php';

$model = new Orcamento($pdo);

$busca = $_GET['busca'] ?? '';
$dataInicio = $_GET['dataInicio'] ?? '';
$dataFim = $_GET['dataFim'] ?? '';

if (!empty($busca)) {
    $orcamentos = $model->buscarPorNome($busca);
}
else if (!empty($dataInicio) || !empty($dataFim)) {
    $orcamentos = $model->filtrarPorPeriodo($dataInicio, $dataFim);
} else {
    $orcamentos = $model->listarOrcamentoModal();
}
?>