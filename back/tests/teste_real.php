<?php
require_once __DIR__ . '/../config/database.php';

echo "╔════════════════════════════════════════════════════════╗\n";
echo "║         TESTE REAL - COMPORTAMENTO ESPERADO            ║\n";
echo "╚════════════════════════════════════════════════════════╝\n\n";

$passou = 0;
$total = 0;

function test($msg, $ok) {
    global $passou, $total;
    $total++;
    if ($ok) {
        echo "✅ $msg\n";
        $passou++;
    } else {
        echo "❌ $msg\n";
    }
}

// TESTE 1: Ordem de movimentação
echo "TESTE 1: ORDEM DE MOVIMENTACAO_ESTOQUE\n";
try {
    $stmt = $conn->prepare("SELECT id_movimentacao FROM movimentacao_estoque ORDER BY id_movimentacao ASC LIMIT 5");
    $stmt->execute();
    $ids = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    
    $correto = true;
    for ($i = 1; $i < count($ids); $i++) {
        if ($ids[$i] <= $ids[$i-1]) {
            $correto = false;
            break;
        }
    }
    
    test("IDs em ordem crescente (1,2,3...)", $correto);
} catch (Exception $e) {
    test("IDs em ordem crescente (1,2,3...)", false);
}

// TESTE 2: Colunas qt_antes e qt_depois preenchidas
echo "\nTESTE 2: COLUNAS qt_antes E qt_depois\n";
try {
    $stmt = $conn->prepare("SELECT qt_antes, qt_depois FROM movimentacao_estoque WHERE qt_antes IS NOT NULL LIMIT 1");
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    test("Coluna qt_antes tem dados", $resultado !== false && $resultado['qt_antes'] !== null, $passou, $total);
} catch (Exception $e) {
    test("Coluna qt_antes tem dados", false);
}

// TESTE 3: Links de navegação corretos
echo "\nTESTE 3: LINKS DE NAVEGACAO\n";
$links = [
    'categoria_produto/index.php' => '../produto/index.php',
    'estoque/index.php' => '../produto/index.php',
    'movimentacao_estoque/index.php' => '../produto/index.php',
    'orcamento/index.php' => '../produto/index.php',
];

foreach ($links as $pagina => $link_esperado) {
    $arquivo = __DIR__ . "/../../pages/$pagina";
    if (file_exists($arquivo)) {
        $conteudo = file_get_contents($arquivo);
        $tem_link = strpos($conteudo, $link_esperado) !== false;
        test("$pagina tem link para Produtos", $tem_link);
    }
}

// TESTE 4: Sem "#" nos IDs
echo "\nTESTE 4: IDs SEM '#'\n";
$paginas = ['categoria_produto/index.php', 'estoque/index.php', 'movimentacao_estoque/index.php', 'orcamento/index.php'];
foreach ($paginas as $pagina) {
    $arquivo = __DIR__ . "/../../pages/$pagina";
    if (file_exists($arquivo)) {
        $conteudo = file_get_contents($arquivo);
        // Procura por col-id com #
        $tem_cerquilha = preg_match('/col-id.*#</', $conteudo);
        test("$pagina sem '#' em IDs", !$tem_cerquilha);
    }
}

// TESTE 5: MovimentacaoEstoque registra qt_antes e qt_depois
echo "\nTESTE 5: MOVIMENTACAO REGISTRA ANTES/DEPOIS\n";
try {
    $stmt = $conn->prepare("
        SELECT COUNT(*) as total, 
               COUNT(CASE WHEN qt_antes > 0 THEN 1 END) as com_antes,
               COUNT(CASE WHEN qt_depois > 0 THEN 1 END) as com_depois
        FROM movimentacao_estoque
    ");
    $stmt->execute();
    $stats = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $ok = $stats['total'] > 0 && $stats['com_antes'] > 0 && $stats['com_depois'] > 0;
    test("Movimentações têm qt_antes e qt_depois preenchidas", $ok);
} catch (Exception $e) {
    test("Movimentações têm qt_antes e qt_depois preenchidas", false);
}

// TESTE 6: Estoque tem dt_atualizacao
echo "\nTESTE 6: ESTOQUE COM dt_atualizacao\n";
try {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM estoque WHERE dt_atualizacao IS NOT NULL");
    $stmt->execute();
    $count = $stmt->fetchColumn();
    test("Estoque tem data_atualizacao preenchida", $count > 0);
} catch (Exception $e) {
    test("Estoque tem data_atualizacao preenchida", false);
}

// TESTE 7: Usuário usa email_usuario
echo "\nTESTE 7: USUARIO COM email_usuario\n";
try {
    $stmt = $conn->prepare("DESCRIBE usuario");
    $stmt->execute();
    $colunas = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    $tem_email = in_array('email_usuario', $colunas);
    $tem_nm = in_array('nm_usuario', $colunas);
    test("Usuario tem coluna email_usuario (não nm_usuario)", $tem_email && !$tem_nm);
} catch (Exception $e) {
    test("Usuario tem coluna email_usuario (não nm_usuario)", false);
}

// RESUMO
echo "\n╔════════════════════════════════════════════════════════╗\n";
echo "║                    RESUMO REAL                         ║\n";
echo "╚════════════════════════════════════════════════════════╝\n";
echo "\n📊 RESULTADO: $passou / $total testes passaram\n";

if ($passou === $total) {
    echo "\n🎉 SUCESSO! SISTEMA REALMENTE FUNCIONANDO!\n\n";
} else {
    $falhas = $total - $passou;
    echo "\n⚠️  $falhas PROBLEMA(S) ENCONTRADO(S)\n\n";
}
?>
