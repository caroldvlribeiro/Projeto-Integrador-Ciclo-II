<?php
require_once 'back/config/database.php';

echo "ADDING MISSING COLUMNS TO movimentacao_estoque\n\n";

try {
    // Check which columns exist
    $stmt = $conn->query("SHOW COLUMNS FROM movimentacao_estoque");
    $cols = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    echo "Existing columns: " . implode(', ', $cols) . "\n\n";

    $missing = [];
    if (!in_array('qt_antes', $cols)) {
        $missing[] = 'qt_antes';
    }
    if (!in_array('qt_depois', $cols)) {
        $missing[] = 'qt_depois';
    }

    if (count($missing) > 0) {
        echo "Missing columns: " . implode(', ', $missing) . "\n";
        echo "Adding columns...\n\n";

        foreach ($missing as $col) {
            $sql = "ALTER TABLE movimentacao_estoque ADD COLUMN $col INT NOT NULL DEFAULT 0 AFTER qt_movimentacao";
            $conn->exec($sql);
            echo "✅ Added $col\n";
        }

        echo "\nVerifying...\n";
        $stmt = $conn->query("SHOW COLUMNS FROM movimentacao_estoque");
        $cols = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        echo "Updated columns: " . implode(', ', $cols) . "\n";
    } else {
        echo "✅ All columns already exist\n";
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
