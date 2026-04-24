<?php
require_once 'classes/Cliente.php'; 
include '../config/database.php';

$_Cliente = new Cliente(null, $_POST['nome'], $_POST['endereco'], $_POST['telefone']);

function addCliente($nome, $endereco, $telefone) {
    global $conn; // Use a variável de conexão global

    $sql = "INSERT INTO clientes (nome, endereco, telefone) VALUES ('$nome', '$endereco', '$telefone')";
    header("Location: ../index.php");
}
?>