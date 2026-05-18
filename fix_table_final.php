<?php
require_once 'back/config/database.php';

echo "FINAL FIX: Recreate table structure correctly\n\n";

try {
    // Get the max ID
    $stmt = $conn->query("SELECT MAX(id_movimentacao) as max_id FROM movimentacao_estoque");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $nextId = ($result['max_id'] ?? 0) + 1;

    echo "Max current id: " . ($nextId - 1) . "\n";
    echo "Next id will start at: $nextId\n\n";

    // Drop the table and recreate it with correct structure
    echo "Recreating table...\n";

    // Save the data first (copy to temp table)
    $conn->exec("CREATE TEMPORARY TABLE temp_mov_backup AS SELECT * FROM movimentacao_estoque");
    echo "✅ Backed up data\n";

    // Drop original table
    $conn->exec("DROP TABLE movimentacao_estoque");
    echo "✅ Dropped original table\n";

    // Recreate with correct structure
    $sql = "CREATE TABLE `movimentacao_estoque` (
      `id_movimentacao` int(11) NOT NULL AUTO_INCREMENT,
      `id_produto` int(11) NOT NULL,
      `qt_movimentacao` int(11) NOT NULL,
      `qt_antes` int(11) NOT NULL DEFAULT 0,
      `qt_depois` int(11) NOT NULL DEFAULT 0,
      `dt_movimentacao` date NOT NULL DEFAULT CURDATE(),
      `tp_movimentacao` enum('Entrada','Saída') NOT NULL,
      PRIMARY KEY (`id_movimentacao`),
      KEY `id_produto` (`id_produto`),
      CONSTRAINT `movimentacao_estoque_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`)
    ) ENGINE=InnoDB AUTO_INCREMENT=$nextId DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    $conn->exec($sql);
    echo "✅ Created new table\n";

    // Restore the data
    $conn->exec("INSERT INTO movimentacao_estoque SELECT * FROM temp_mov_backup");
    echo "✅ Restored data\n\n";

    // Verify
    $stmt = $conn->query("SHOW CREATE TABLE movimentacao_estoque");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $createSql = $row['Create Table'];

    echo "Verification:\n";
    if (strpos($createSql, 'AUTO_INCREMENT') !== false) {
        echo "✅ AUTO_INCREMENT present\n";
    }
    if (strpos($createSql, 'PRIMARY KEY') !== false) {
        echo "✅ PRIMARY KEY present\n";
    }
    if (strpos($createSql, "enum('Entrada','Saída')") !== false) {
        echo "✅ Enum values correct\n";
    }

    echo "\nTable structure verified!\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
