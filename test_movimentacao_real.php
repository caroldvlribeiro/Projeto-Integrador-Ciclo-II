<?php
require_once 'back/config/database.php';
require_once 'back/models/MovimentacaoEstoque.php';

echo "TEST: MovimentacaoEstoque Entrada + Saída\n\n";

// Get a product and note initial quantity
$stmt = $conn->prepare("SELECT id_produto, qt_estoque FROM estoque LIMIT 1");
$stmt->execute();
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

$id_produto = $produto['id_produto'];
$qt_inicial = (int)$produto['qt_estoque'];

echo "Initial: ID=$id_produto, QT=$qt_inicial\n\n";

// Test 1: Entrada
echo "--- TEST 1: Entrada de 5 unidades ---\n";
$mov1 = new MovimentacaoEstoque($conn);
$mov1->setProduto($id_produto);
$mov1->setQuantidade(5);
$mov1->setTipo('Entrada');

$resultado1 = $mov1->salvar();
echo "salvar() returned: " . ($resultado1 ? 'TRUE' : 'FALSE') . "\n";

$stmt = $conn->prepare("SELECT qt_estoque FROM estoque WHERE id_produto = ?");
$stmt->execute([$id_produto]);
$qt_after_entrada = (int)$stmt->fetchColumn();

$esperado_entrada = $qt_inicial + 5;
echo "After Entrada: $qt_after_entrada (expected: $esperado_entrada)\n";
if ($qt_after_entrada === $esperado_entrada) {
    echo "✅ PASS\n\n";
} else {
    echo "❌ FAIL - diferença: " . ($qt_after_entrada - $esperado_entrada) . "\n\n";
}

// Test 2: Saída
echo "--- TEST 2: Saída de 2 unidades ---\n";
$mov2 = new MovimentacaoEstoque($conn);
$mov2->setProduto($id_produto);
$mov2->setQuantidade(2);
$mov2->setTipo('Saída');

$resultado2 = $mov2->salvar();
echo "salvar() returned: " . ($resultado2 ? 'TRUE' : 'FALSE') . "\n";

$stmt = $conn->prepare("SELECT qt_estoque FROM estoque WHERE id_produto = ?");
$stmt->execute([$id_produto]);
$qt_after_saida = (int)$stmt->fetchColumn();

$esperado_saida = $qt_after_entrada - 2;
echo "After Saída: $qt_after_saida (expected: $esperado_saida)\n";
if ($qt_after_saida === $esperado_saida) {
    echo "✅ PASS\n\n";
} else {
    echo "❌ FAIL - diferença: " . ($qt_after_saida - $esperado_saida) . "\n\n";
}

// Verify in movimentacao_estoque table
echo "--- Movimentacao Records ---\n";
$stmt = $conn->prepare("SELECT * FROM movimentacao_estoque WHERE id_produto = ? ORDER BY id_movimentacao DESC LIMIT 2");
$stmt->execute([$id_produto]);
$movs = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($movs as $m) {
    echo "ID: {$m['id_movimentacao']}, Type: {$m['tp_movimentacao']}, Qtd: {$m['qt_movimentacao']}, Antes: {$m['qt_antes']}, Depois: {$m['qt_depois']}\n";
}
?>
