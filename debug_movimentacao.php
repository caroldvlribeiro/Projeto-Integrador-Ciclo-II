<?php
require_once 'back/config/database.php';
require_once 'back/models/MovimentacaoEstoque.php';

echo "DEBUG: Problema na MovimentacaoEstoque::salvar()\n\n";

$stmt = $conn->prepare("SELECT id_produto, qt_estoque FROM estoque LIMIT 1");
$stmt->execute();
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

echo "Produto: ID={$produto['id_produto']}, QT Antes={$produto['qt_estoque']}\n\n";

$mov = new MovimentacaoEstoque($conn);
$mov->setProduto($produto['id_produto']);
$mov->setQuantidade(1);
$mov->setTipo('Entrada');

$resultado = $mov->salvar();
echo "salvar() retornou: " . ($resultado ? 'TRUE' : 'FALSE') . "\n";
echo "Erro: " . ($mov->getError() ?? 'NENHUM') . "\n\n";

// Verificar estoque depois
$stmt2 = $conn->prepare("SELECT qt_estoque FROM estoque WHERE id_produto = ?");
$stmt2->execute([$produto['id_produto']]);
$qt_depois = $stmt2->fetchColumn();

echo "QT Depois: $qt_depois\n";
echo "Aumentou corretamente? " . ($qt_depois === ($produto['qt_estoque'] + 1) ? 'SIM' : 'NAO') . "\n\n";

// Verificar se movimentação foi registrada
$stmt3 = $conn->prepare("SELECT * FROM movimentacao_estoque WHERE id_produto = ? ORDER BY id_movimentacao DESC LIMIT 1");
$stmt3->execute([$produto['id_produto']]);
$mov_data = $stmt3->fetch(PDO::FETCH_ASSOC);

if ($mov_data) {
    echo "Movimentacao registrada:\n";
    echo "  qt_antes: {$mov_data['qt_antes']}\n";
    echo "  qt_depois: {$mov_data['qt_depois']}\n";
    echo "  tp_movimentacao: {$mov_data['tp_movimentacao']}\n";
} else {
    echo "ERRO: Movimentacao NÃO foi registrada!\n";
}
?>
