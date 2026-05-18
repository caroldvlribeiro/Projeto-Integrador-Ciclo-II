<?php
require_once 'back/config/database.php';

echo "FIXING ENUM VALUES IN movimentacao_estoque\n\n";

try {
    $sql = "ALTER TABLE movimentacao_estoque MODIFY COLUMN tp_movimentacao ENUM('Entrada', 'Saída') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL";

    $stmt = $conn->prepare($sql);
    $resultado = $stmt->execute();

    if ($resultado) {
        echo "✅ Enum column fixed successfully!\n\n";

        // Verify the fix
        $stmt = $conn->query("SHOW FULL COLUMNS FROM movimentacao_estoque WHERE Field = 'tp_movimentacao'");
        $col = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "New column definition: {$col['Type']}\n";
    } else {
        echo "❌ Error fixing enum\n";
    }
} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "\n";
}
?>
