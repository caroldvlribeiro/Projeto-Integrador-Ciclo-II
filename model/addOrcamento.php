<?php
require_once 'classes/Orcamento.php';
require_once 'classes/Cliente.php';
include '../config/database.php';

$_Orcamento = new Orcamento(null, $_POST['cliente'], $_POST['dataEntrega'], $_POST['dataPedido'], $_POST['descricao'], $_POST['acabamento'], $_POST['material'], $_POST['cuba'], $_POST['vista'], $_POST['saia'], $_POST['status'], $_POST['vlEntrada'], $_POST['vlRestante'], $_POST['vlTotal']);

function addOrcamento($cliente, $dataEntrega, $dataPedido, $descricao, $acabamento, $material, $cuba, $vista, $saia, $status, $vlEntrada, $vlRestante, $vlTotal) {
    global $conn; // Use a variável de conexão global

    $sql = "INSERT INTO orcamentos (cliente_id, dataEntrega, dataPedido, descricao, acabamento, material, cuba, vista, saia, status, vlEntrada, vlRestante, vlTotal) VALUES ('$cliente', '$dataEntrega', '$dataPedido', '$descricao', '$acabamento', '$material', '$cuba', '$vista', '$saia', '$status', '$vlEntrada', '$vlRestante', '$vlTotal')";
    header("Location: ../index.php");
}
?>