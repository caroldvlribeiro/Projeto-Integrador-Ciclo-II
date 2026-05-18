<?php
require_once 'back/config/database.php';

echo "DATABASE ENCODING CHECK\n\n";

// Check database charset
$stmt = $conn->query("SELECT DEFAULT_CHARACTER_SET_NAME, DEFAULT_COLLATION_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = DATABASE()");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
echo "Database charset: {$row['DEFAULT_CHARACTER_SET_NAME']}\n";
echo "Database collation: {$row['DEFAULT_COLLATION_NAME']}\n\n";

// Check table structure
echo "Table movimentacao_estoque structure:\n";
$stmt = $conn->query("SHOW FULL COLUMNS FROM movimentacao_estoque");
$cols = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($cols as $col) {
    echo "  {$col['Field']}: {$col['Type']} (Collation: {$col['Collation']})\n";
}

// Check what's actually in the table
echo "\nActual data in movimentacao_estoque (last 3):\n";
$stmt = $conn->prepare("SELECT id_movimentacao, tp_movimentacao, LENGTH(tp_movimentacao) as len FROM movimentacao_estoque ORDER BY id_movimentacao DESC LIMIT 3");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $r) {
    echo "  ID {$r['id_movimentacao']}: tp_movimentacao='{$r['tp_movimentacao']}' (length: {$r['len']})\n";
}
?>
