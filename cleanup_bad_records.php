<?php
require_once 'back/config/database.php';

echo "CLEANING UP CORRUPT movimentacao_estoque RECORDS\n\n";

// Find records with empty tp_movimentacao
$stmt = $conn->prepare("SELECT id_movimentacao FROM movimentacao_estoque WHERE tp_movimentacao = '' OR tp_movimentacao IS NULL");
$stmt->execute();
$bad_ids = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

echo "Found " . count($bad_ids) . " records with empty tp_movimentacao\n";

if (count($bad_ids) > 0) {
    echo "Deleting records: " . implode(', ', $bad_ids) . "\n\n";

    $sql = "DELETE FROM movimentacao_estoque WHERE tp_movimentacao = '' OR tp_movimentacao IS NULL";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute()) {
        echo "✅ Deleted successfully\n";
    } else {
        echo "❌ Error deleting\n";
    }
} else {
    echo "✅ No bad records found\n";
}
?>
