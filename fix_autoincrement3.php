<?php
require_once 'back/config/database.php';

echo "FIXING AUTO_INCREMENT - Attempt 3\n\n";

try {
    // Get max id
    $stmt = $conn->query("SELECT MAX(id_movimentacao) as max_id FROM movimentacao_estoque");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $maxId = $result['max_id'] ?? 0;
    $nextId = $maxId + 1;

    echo "Max id: $maxId, Next: $nextId\n\n";

    // Try to just modify the column
    $sql = "ALTER TABLE movimentacao_estoque MODIFY COLUMN id_movimentacao INT(11) NOT NULL AUTO_INCREMENT";
    $conn->exec($sql);
    echo "✅ Added AUTO_INCREMENT\n";

    // Try to add primary key
    $sql = "ALTER TABLE movimentacao_estoque ADD PRIMARY KEY (id_movimentacao)";
    $conn->exec($sql);
    echo "✅ Added PRIMARY KEY\n";

    // Set AUTO_INCREMENT start value
    $conn->exec("ALTER TABLE movimentacao_estoque AUTO_INCREMENT=$nextId");
    echo "✅ Set AUTO_INCREMENT start to $nextId\n\n";

    // Verify
    $stmt = $conn->query("SHOW CREATE TABLE movimentacao_estoque");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Verification:\n";
    if (strpos($row['Create Table'], 'AUTO_INCREMENT') !== false) {
        echo "✅ AUTO_INCREMENT present\n";
    }
    if (strpos($row['Create Table'], 'PRIMARY KEY') !== false) {
        echo "✅ PRIMARY KEY present\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
