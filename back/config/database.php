<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "marmoraria_db";
try{
    $pdo = new PDO("mysql:host=$host;dbname=$banco", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Conectado com sucesso";
} //mostra se der erro na conexao
catch(PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
}
?>