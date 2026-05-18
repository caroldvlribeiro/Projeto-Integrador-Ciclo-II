<?php
require_once 'back/config/database.php';

echo "DEBUG: Problema no aumento de estoque\n\n";

// Verificar colunas
$stmt = $conn->prepare('DESCRIBE estoque');
$stmt->execute();
$cols = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
echo 'Colunas em estoque: ' . implode(', ', $cols) . "\n\n";

// Testar UPDATE básico
$stmt = $conn->prepare('SELECT id_produto, qt_estoque FROM estoque LIMIT 1');
$stmt->execute();
$antes = $stmt->fetch(PDO::FETCH_ASSOC);

echo "Antes: ID={$antes['id_produto']}, QT={$antes['qt_estoque']}\n";

// Fazer UPDATE
$stmt = $conn->prepare('UPDATE estoque SET qt_estoque = qt_estoque + 1 WHERE id_produto = ?');
$resultado = $stmt->execute([$antes['id_produto']]);
echo "UPDATE executado: " . ($resultado ? 'SIM' : 'NAO') . "\n";

// Verificar resultado
$stmt = $conn->prepare('SELECT qt_estoque FROM estoque WHERE id_produto = ?');
$stmt->execute([$antes['id_produto']]);
$depois = $stmt->fetch(PDO::FETCH_COLUMN);

echo "Depois: QT=$depois\n";
echo "Tipo antes: " . gettype($antes['qt_estoque']) . "\n";
echo "Tipo depois: " . gettype($depois) . "\n";
echo "Comparação (===): " . ($depois === ($antes['qt_estoque'] + 1) ? 'SIM' : 'NAO') . "\n";
echo "Comparação (==): " . ($depois == ($antes['qt_estoque'] + 1) ? 'SIM' : 'NAO') . "\n";
?>
