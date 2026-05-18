<?php
require_once 'back/config/database.php';

echo "TRIGGERS NO BANCO DE DADOS\n\n";

$stmt = $conn->query("SHOW TRIGGERS");
$triggers = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($triggers) === 0) {
    echo "Nenhum trigger encontrado.\n";
} else {
    foreach ($triggers as $t) {
        echo "Trigger: {$t['Trigger']}\n";
        echo "  Table: {$t['Table']}\n";
        echo "  Event: {$t['Event']}\n";
        echo "  Timing: {$t['Timing']}\n";
        echo "  Statement: {$t['Statement']}\n\n";
    }
}
?>
