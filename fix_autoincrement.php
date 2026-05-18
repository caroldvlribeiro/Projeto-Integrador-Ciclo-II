<?php
require_once 'back/config/database.php';

echo "FIXING AUTO_INCREMENT ON id_movimentacao\n\n";

try {
    // First, drop the primary key
    $conn->exec("ALTER TABLE movimentacao_estoque DROP PRIMARY KEY");
    echo "✅ Dropped PRIMARY KEY\n";

    // Add AUTO_INCREMENT to id_movimentacao and recreate primary key
    $conn->exec("ALTER TABLE movimentacao_estoque MODIFY COLUMN id_movimentacao INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY");
    echo "✅ Added AUTO_INCREMENT and PRIMARY KEY\n\n";

    // Verify
    $stmt = $conn->query('SHOW CREATE TABLE movimentacao_estoque');
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $createSql = $row['Create Table'];

    if (strpos($createSql, 'AUTO_INCREMENT') !== false) {
        echo "✅ AUTO_INCREMENT is now present\n";
        echo "\nVerified structure:\n";
        $lines = explode("\n", $createSql);
        foreach ($lines as $line) {
            if (strpos($line, 'id_movimentacao') !== false) {
                echo trim($line) . "\n";
            }
        }
    } else {
        echo "❌ AUTO_INCREMENT still missing\n";
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
