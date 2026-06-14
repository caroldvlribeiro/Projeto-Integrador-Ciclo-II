<?php
require_once '../../back/config/database.php';
require_once '../../back/models/Orcamento.php';

$model = new Orcamento($pdo);

$busca = $_GET['busca'] ?? '';
$dataInicio = $_GET['dataInicio'] ?? '';
$dataFim = $_GET['dataFim'] ?? '';

$orcamentos = $model->listarComFiltros($busca, $dataInicio, $dataFim);
?>