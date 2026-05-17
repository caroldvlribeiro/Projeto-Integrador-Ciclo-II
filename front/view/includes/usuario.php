<?php
require_once '../../back/config/database.php';
require_once '../../back/models/Usuario.php';
require_once '../../back/models/Vendedor.php';
require_once '../../back/models/Orcamento.php';

$modelU = new Usuario($pdo);
$modelV = new Vendedor($pdo);
$modelO = new Orcamento($pdo);

$usuario = $modelU->getPerfil(4);
$tipo = $modelU->getTipo();

$relatorio = [];
$vendas = [];

if ($tipo === 'Administrador' || $tipo === 'Vendedor') {
    $vendas = $modelV->listarVendas(4);
}
if ($tipo === 'Administrador') {
    $inicio = $_GET['inicio'] ?? null;
    $fim = $_GET['fim'] ?? null;
    $status = $_GET['status'] ?? null;

    $relatorio = $modelO->gerarRelatorio($inicio, $fim, $status);

    $totalVendas = 0;

    foreach($relatorio as $item){
        $totalVendas += $item['vl_total'];
    }
}

