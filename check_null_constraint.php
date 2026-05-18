<?php
require_once 'back/config/database.php';

$stmt = $conn->query("SHOW CREATE TABLE movimentacao_estoque");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
echo $row['Create Table'];
?>
