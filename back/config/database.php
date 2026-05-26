<?php
$host = "localhost";
$usuario = "danilo";
$senha = "Dani4520*";
$banco = "marmoraria_db";
try{
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8mb4", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Conectado com sucesso";
} //mostra se der erro na conexao
catch(PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
}
?>