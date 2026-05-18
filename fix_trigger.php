<?php
require_once 'back/config/database.php';

echo "FIXING atualizar_estoque TRIGGER\n\n";

try {
    // Drop the old trigger
    $sql_drop = "DROP TRIGGER IF EXISTS atualizar_estoque";
    $stmt = $conn->prepare($sql_drop);
    $stmt->execute();
    echo "✅ Old trigger dropped\n\n";

    // Create the new trigger with correct values
    $sql_create = "CREATE TRIGGER atualizar_estoque
                   AFTER INSERT ON movimentacao_estoque
                   FOR EACH ROW
                   BEGIN
                       IF NEW.tp_movimentacao = 'Entrada' THEN
                           UPDATE estoque
                           SET qt_estoque = qt_estoque + NEW.qt_movimentacao,
                               dt_atualizacao = CURRENT_DATE
                           WHERE id_produto = NEW.id_produto;
                       ELSEIF NEW.tp_movimentacao = 'Saída' THEN
                           UPDATE estoque
                           SET qt_estoque = qt_estoque - NEW.qt_movimentacao,
                               dt_atualizacao = CURRENT_DATE
                           WHERE id_produto = NEW.id_produto;
                       END IF;
                   END";

    $stmt = $conn->prepare($sql_create);
    $stmt->execute();
    echo "✅ New trigger created with correct 'Saída' value\n\n";

    // Verify
    $stmt = $conn->query("SHOW TRIGGERS WHERE `Trigger` = 'atualizar_estoque'");
    $trigger = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Trigger statement:\n" . $trigger['Statement'] . "\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
