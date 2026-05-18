<?php
require_once 'back/config/database.php';

echo "FIXING AUTO_INCREMENT ON id_movimentacao (Safe Method)\n\n";

try {
    // Get the maximum id currently in the table
    $stmt = $conn->query("SELECT MAX(id_movimentacao) as max_id FROM movimentacao_estoque");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $maxId = $result['max_id'] ?? 0;
    $nextId = $maxId + 1;

    echo "Current max id: $maxId\n";
    echo "Next id will be: $nextId\n\n";

    // First, drop the primary key
    $conn->exec("ALTER TABLE movimentacao_estoque DROP PRIMARY KEY");
    echo "✅ Dropped PRIMARY KEY\n";

    // Add AUTO_INCREMENT with starting value
    $conn->exec("ALTER TABLE movimentacao_estoque MODIFY COLUMN id_movimentacao INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY");
    $conn->exec("ALTER TABLE movimentacao_estoque AUTO_INCREMENT=$nextId");
    echo "✅ Added AUTO_INCREMENT starting at $nextId\n\n";

    // Verify
    $stmt = $conn->query('SHOW CREATE TABLE movimentacao_estoque');
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $createSql = $row['Create Table'];

    if (strpos($createSql, 'AUTO_INCREMENT') !== false) {
        echo "✅ Structure verified\n";
    } else {
        echo "❌ AUTO_INCREMENT not found\n";
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
