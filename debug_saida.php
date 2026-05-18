<?php
require_once 'back/config/database.php';
require_once 'back/models/MovimentacaoEstoque.php';

echo "DEBUG: Why is Saída failing?\n\n";

// Get a product
$stmt = $conn->prepare("SELECT id_produto, qt_estoque FROM estoque WHERE id_produto = 1");
$stmt->execute();
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

$inicial = $produto['qt_estoque'];
echo "Produto: ID={$produto['id_produto']}, QT=$inicial\n\n";

// Test Saída
$mov = new MovimentacaoEstoque($conn);
$mov->setProduto($produto['id_produto']);
$mov->setQuantidade(2);
$mov->setTipo('Saída');

echo "Saída test: quantidade=2, tipo='Saída'\n";
echo "Quantity sufficient? " . ($inicial >= 2 ? 'YES' : 'NO') . "\n\n";

$resultado = $mov->salvar();

echo "Result: " . ($resultado ? 'TRUE' : 'FALSE') . "\n";
echo "Error: " . ($mov->getError() ?? 'NO ERROR') . "\n";

// Check what's in the database
$stmt = $conn->prepare("SELECT qt_estoque FROM estoque WHERE id_produto = 1");
$stmt->execute();
$depois = $stmt->fetchColumn();
echo "\nEstoque after: $depois (expected: " . ($inicial - 2) . ")\n";
?>
