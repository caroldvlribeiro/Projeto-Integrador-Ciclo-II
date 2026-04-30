<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "marmoraria_db";
try{
    $conn = new PDO("mysql:host=$host;dbname=$banco", $usuario, $senha);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conectado com sucesso";
} //mostra se der erro na conexao
catch(PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
}
?>