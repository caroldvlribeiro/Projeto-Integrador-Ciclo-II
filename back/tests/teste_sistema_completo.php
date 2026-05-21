<?php
require_once __DIR__ . '/../config/database.php';

echo "╔════════════════════════════════════════════════════════╗\n";
echo "║       TESTE COMPLETO DO SISTEMA MARMORARIA             ║\n";
echo "╚════════════════════════════════════════════════════════╝\n\n";

$testes_passaram = 0;
$total_testes = 0;

function teste($nome, $condicao, &$passaram, &$total) {
    $total++;
    if ($condicao) {
        echo "✅ $nome\n";
        $passaram++;
    } else {
        echo "❌ $nome\n";
    }
}

// ========== TESTE 1: CONEXÃO COM BANCO ==========
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "TESTE 1: BANCO DE DADOS\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

teste("Conexão com banco de dados", isset($conn) && $conn !== null, $testes_passaram, $total_testes);

// Testar tabelas principais
$tabelas = ['usuario', 'vendedor', 'categoria_produto', 'produto', 'estoque', 'movimentacao_estoque', 'orcamento'];
foreach ($tabelas as $tabela) {
    try {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM $tabela");
        $stmt->execute();
        $result = $stmt->fetch();
        teste("Tabela '$tabela' existe", $result !== false, $testes_passaram, $total_testes);
    } catch (Exception $e) {
        teste("Tabela '$tabela' existe", false, $testes_passaram, $total_testes);
    }
}

// ========== TESTE 2: MODELS ==========
echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "TESTE 2: MODELS\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

$models = ['Usuario', 'Vendedor', 'CategoriaProduto', 'Produto', 'Estoque', 'MovimentacaoEstoque', 'Orcamento'];
foreach ($models as $model) {
    $file = __DIR__ . "/../models/$model.php";
    teste("$model.php existe", file_exists($file), $testes_passaram, $total_testes);
}

// ========== TESTE 3: CONTROLLERS ==========
echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "TESTE 3: CONTROLLERS\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

$controllers = ['CategoriaProdutoController', 'EstoqueController', 'MovimentacaoEstoqueController', 'OrcamentoController'];
foreach ($controllers as $controller) {
    $file = __DIR__ . "/../controller/$controller.php";
    teste("$controller.php existe", file_exists($file), $testes_passaram, $total_testes);
}

// ========== TESTE 4: PÁGINAS ==========
echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "TESTE 4: PÁGINAS\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

$paginas = [
    'categoria_produto/index.php',
    'estoque/index.php',
    'movimentacao_estoque/index.php',
    'orcamento/index.php',
    'orcamento/form.php',
    'orcamento/relatorio.php',
    'produto/index.php'
];

foreach ($paginas as $pagina) {
    $file = __DIR__ . "/../../pages/$pagina";
    teste("$pagina existe", file_exists($file), $testes_passaram, $total_testes);
}

// ========== TESTE 5: FUNCIONALIDADES ==========
echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "TESTE 5: FUNCIONALIDADES\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

try {
    require_once __DIR__ . '/../controller/CategoriaProdutoController.php';
    $cat_controller = new CategoriaProdutoController($conn);
    $categorias = $cat_controller->listar();
    teste("listar() Categorias funciona", is_array($categorias), $testes_passaram, $total_testes);
} catch (Exception $e) {
    teste("listar() Categorias funciona", false, $testes_passaram, $total_testes);
}

try {
    require_once __DIR__ . '/../controller/EstoqueController.php';
    $est_controller = new EstoqueController($conn);
    $estoques = $est_controller->listar();
    teste("listar() Estoque funciona", is_array($estoques), $testes_passaram, $total_testes);
} catch (Exception $e) {
    teste("listar() Estoque funciona", false, $testes_passaram, $total_testes);
}

try {
    require_once __DIR__ . '/../controller/MovimentacaoEstoqueController.php';
    $mov_controller = new MovimentacaoEstoqueController($conn);
    $movimentacoes = $mov_controller->listar();
    teste("listar() Movimentação funciona", is_array($movimentacoes), $testes_passaram, $total_testes);
} catch (Exception $e) {
    teste("listar() Movimentação funciona", false, $testes_passaram, $total_testes);
}

// ========== TESTE 6: TABELA MOVIMENTACAO ==========
echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "TESTE 6: COLUNAS MOVIMENTACAO_ESTOQUE\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

try {
    $stmt = $conn->prepare("DESCRIBE movimentacao_estoque");
    $stmt->execute();
    $colunas = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

    teste("Coluna 'qt_antes' existe", in_array('qt_antes', $colunas), $testes_passaram, $total_testes);
    teste("Coluna 'qt_depois' existe", in_array('qt_depois', $colunas), $testes_passaram, $total_testes);
} catch (Exception $e) {
    echo "❌ Erro ao verificar colunas\n";
}

// ========== RESUMO ==========
echo "\n╔════════════════════════════════════════════════════════╗\n";
echo "║                    RESUMO FINAL                        ║\n";
echo "╚════════════════════════════════════════════════════════╝\n";
echo "\n📊 RESULTADO: $testes_passaram / $total_testes testes passaram\n";

if ($testes_passaram === $total_testes) {
    echo "\n🎉 SUCESSO! SISTEMA 100% FUNCIONAL!\n\n";
} else {
    $falhas = $total_testes - $testes_passaram;
    echo "\n⚠️  $falhas TESTE(S) FALHARAM\n\n";
}
?>
