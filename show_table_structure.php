<?php
require_once 'back/config/database.php';

$stmt = $conn->query('SHOW CREATE TABLE movimentacao_estoque');
$row = $stmt->fetch(PDO::FETCH_ASSOC);
echo $row['Create Table'];
echo "\n\n";

// Also show current data
echo "Current data (last 2 rows):\n";
$stmt = $conn->query("SELECT * FROM movimentacao_estoque ORDER BY id_movimentacao DESC LIMIT 2");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $r) {
    print_r($r);
}
?>
