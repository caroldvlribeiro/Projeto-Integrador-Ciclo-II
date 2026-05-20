<?php
/**
 * SUPER VIEW DE TESTE - SISTEMA DE MARMORARIA
 * Este arquivo testa o fluxo completo: Autenticação -> Cadastros -> Orçamento -> Venda -> Estoque.
 */

header('Content-Type: text/html; charset=utf-8');

// 1. Configuração de Conexão (Ajuste conforme seu ambiente)
try {
    $host = 'localhost';
    $db = 'marmoraria_db';
    $user = 'root';
    $pass = '';
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    echo "<h2 style='color: green;'>✅ Conexão OK!</h2>";
} catch (Exception $e) {
    die("<h2 style='color: red;'>❌ Erro de Conexão: " . $e->getMessage() . "</h2>");
}

// 2. Inclusão Automática dos Models (Simulando um Autoload simples)
$models = [
    'Model',
    'Pessoa',
    'ItemEstoque',
    'RegistroFinanceiro',
    'Usuario',
    'Vendedor',
    'Cliente',
    'Pedra',
    'Produto',
    'CategoriaProduto',
    'Orcamento',
    'Agenda',
    'Venda',
    'Pagamento',
    'Estoque',
    'MovimentacaoEstoque'
];

foreach ($models as $model) {
    require_once "../models/{$model}.php";
}

function imprimirResultado($titulo, $sucesso, $erro = "")
{
    $cor = $sucesso ? "green" : "red";
    $status = $sucesso ? "✅ SUCESSO" : "❌ FALHA";
    echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 5px; border-left: 5px solid $cor;'>";
    echo "<b>$titulo:</b> <span style='color: $cor;'>$status</span>";
    if (!$sucesso)
        echo "<br><small style='color: gray;'>Erro: $erro</small>";
    echo "</div>";
}

echo "<h3>🚀 Iniciando Teste de Fluxo Completo</h3>";

// --- TESTE 1: USUÁRIO E AUTENTICAÇÃO ---
$user = new Usuario($pdo);
$user->setNome("Admin_" . rand(10, 99));
$user->setSenha("senha123");
$user->setTipo("Administrador");
$res1 = $user->salvar();
$resAuth = $user->autenticar($user->getNome(), "senha123");
imprimirResultado("Cadastro e Login de Usuário", $res1 && $resAuth, $user->getError());

// --- TESTE 2: CLIENTE ---
$cli = new Cliente($pdo);
$cli->setNome("Cliente Teste " . rand(100, 999));
$cli->setTelefone("11988887777");
$cli->setEndereco("Rua das Pedras, 500");
$res2 = $cli->salvar();
$idCli = $pdo->lastInsertId();
imprimirResultado("Cadastro de Cliente", $res2, $cli->getError());

// --- TESTE 3: CATEGORIA E PRODUTO ---
$cat = new CategoriaProduto($pdo);
$cat->setNome("Cubas");
$cat->setDescricao("Cubas de Inox e Porcelana");
$resCat = $cat->salvar();
$idCat = $pdo->lastInsertId();

$prod = new Produto($pdo);
$prod->setNome("Cuba Inox Luxo");
$prod->setDescricao("Cuba de embutir");
$prod->setVlCompra(200.00);
$prod->setCategoria($idCat);
$res3 = $prod->salvar();
imprimirResultado("Cadastro de Categoria e Produto", $resCat && $res3, $prod->getError());

// --- TESTE 4: PEDRA ---
$pedra = new Pedra($pdo);
$pedra->setNome("Granito Preto São Gabriel");
$pedra->setDescricao("Pedra polida");
$pedra->setVlCompra(350.00);
$res4 = $pedra->salvar();
$idPedra = $pdo->lastInsertId();
imprimirResultado("Cadastro de Pedra (Material)", $res4, $pedra->getError());

// --- TESTE 5: ORÇAMENTO ---
$orc = new Orcamento($pdo);
$orc->setCliente($idCli);
$orc->setPedra($idPedra);
$orc->setValor(1500.00);
$orc->setDescricao("Pia de cozinha em L");
$orc->setAcabamento("45 graus");
$orc->setStatus("Aberto");
$res5 = $orc->salvar();
$idOrc = $pdo->lastInsertId();
imprimirResultado("Geração de Orçamento", $res5, $orc->getError());

// --- TESTE 6: AGENDA ---
$age = new Agenda($pdo);
$age->setCliente($idCli);
$age->setOrcamento($idOrc);
$age->setData(date('Y-m-d', strtotime('+2 days')));
$age->setHora("14:00");
$age->setDescricao("Medição técnica no local");
$res6 = $age->salvar();
imprimirResultado("Agendamento de Medição", $res6, $age->getError());

// --- TESTE 7: ESTOQUE E MOVIMENTAÇÃO ---
$est = new Estoque($pdo);
$est->setProduto($pdo->lastInsertId('produtos')); // Pega o último produto cadastrado
$est->setQuantidade(10);
$res7 = $est->salvar();

$mov = new MovimentacaoEstoque($pdo);
$mov->setProduto($pdo->lastInsertId('produtos'));
$mov->setQuantidade(10);
$mov->setTipo("E"); // Entrada
$resMov = $mov->salvar();
imprimirResultado("Controle de Estoque (Saldo e Movimentação)", $res7 && $resMov, $est->getError());

echo "<hr><p><b>Dica:</b> Se todos os testes acima passaram, seu sistema está pronto para ser usado pelos Controllers reais!</p>";
?>