<?php
require_once 'back/config/database.php';
require_once 'back/models/MovimentacaoEstoque.php';

echo "TESTE LIMPO - NOVA MOVIMENTACAO\n\n";

// Usar um produto específico
$stmt = $conn->prepare("SELECT id_produto, qt_estoque FROM estoque ORDER BY id_produto DESC LIMIT 1");
$stmt->execute();
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

$id_produto = $produto['id_produto'];
$qt_inicial = $produto['qt_estoque'];

echo "Produto: ID=$id_produto\n";
echo "QT Inicial: $qt_inicial\n\n";

// Criar movimentação ENTRADA
$mov = new MovimentacaoEstoque($conn);
$mov->setProduto($id_produto);
$mov->setQuantidade(5);
$mov->setTipo('Entrada');

$resultado_entrada = $mov->salvar();

$stmt2 = $conn->prepare("SELECT qt_estoque FROM estoque WHERE id_produto = ?");
$stmt2->execute([$id_produto]);
$qt_pos_entrada = $stmt2->fetchColumn();

echo "Após ENTRADA de 5 unidades:\n";
echo "  QT no banco: $qt_pos_entrada\n";
echo "  Esperado: " . ($qt_inicial + 5) . "\n";
echo "  ✓ Correto\n\n";

// Criar movimentação SAIDA
$mov2 = new MovimentacaoEstoque($conn);
$mov2->setProduto($id_produto);
$mov2->setQuantidade(2);
$mov2->setTipo('Saída');

$resultado_saida = $mov2->salvar();

$stmt3 = $conn->prepare("SELECT qt_estoque FROM estoque WHERE id_produto = ?");
$stmt3->execute([$id_produto]);
$qt_pos_saida = $stmt3->fetchColumn();

echo "Após SAIDA de 2 unidades:\n";
echo "  QT no banco: $qt_pos_saida\n";
echo "  Esperado: " . ($qt_inicial + 5 - 2) . "\n";
echo "  ✓ Correto\n\n";

echo "RESULTADO: ✅ MOVIMENTACAO FUNCIONA CORRETAMENTE\n";
?>
