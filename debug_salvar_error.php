<?php
require_once 'back/config/database.php';
require_once 'back/models/MovimentacaoEstoque.php';

echo "DEBUG: Why is salvar() failing?\n\n";

// Get a product
$stmt = $conn->prepare("SELECT id_produto, qt_estoque FROM estoque LIMIT 1");
$stmt->execute();
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

echo "Produto: ID={$produto['id_produto']}, QT={$produto['qt_estoque']}\n\n";

// Create movimentacao
$mov = new MovimentacaoEstoque($conn);
$mov->setProduto($produto['id_produto']);
$mov->setQuantidade(5);
$mov->setTipo('Entrada');

echo "Before salvar():\n";
echo "  id_produto set? " . ($produto['id_produto'] ? 'YES' : 'NO') . "\n";
echo "  quantidade set? YES (5)\n";
echo "  tipo set? YES (Entrada)\n\n";

$resultado = $mov->salvar();

echo "After salvar():\n";
echo "  Result: " . ($resultado ? 'TRUE' : 'FALSE') . "\n";
echo "  Error: " . ($mov->getError() ?? 'NO ERROR') . "\n";
?>
