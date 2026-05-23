<?php
require_once __DIR__ . '/../../../back/controller/AuthController.php';
require_once __DIR__ . '/../../../back/controller/UsuarioController.php';
require_once __DIR__ . '/../../../back/config/database.php';
require_once __DIR__ . '/../../../back/models/Usuario.php';
require_once __DIR__ . '/../../../back/models/Vendedor.php';
require_once __DIR__ . '/../../../back/models/Orcamento.php';

$auth = new AuthController();

// Logout via ?acao=logout na URL
if (isset($_GET['acao']) && $_GET['acao'] === 'logout') {
    $auth->logout();
}

// Redireciona para Login.php se não houver sessão ativa
$auth->verificarSessao();

$logado = $_SESSION['usuario'];
$idUsuario = $logado['id_usuario'];
$tipo = $logado['tp_usuario']; // 'Administrador' ou 'Vendedor'

$modelU = new Usuario($pdo);
$modelV = new Vendedor($pdo);
$modelO = new Orcamento($pdo);

// Variáveis de feedback exibidas pelo banner após o POST
$feedbackMsg = '';
$feedbackTipo = ''; // 'sucesso' | 'erro'

// Processa alteração de e-mail
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'alterar_email') {
    $ctrl = new UsuarioController();
    $resultado = $ctrl->alterarEmail(
        $idUsuario,
        trim($_POST['novo_email'] ?? ''),
        $_POST['senha_atual_email'] ?? ''
    );
    $feedbackMsg = $resultado['sucesso'] ? 'E-mail atualizado com sucesso!' : ($resultado['erro'] ?? 'Erro desconhecido.');
    $feedbackTipo = $resultado['sucesso'] ? 'sucesso' : 'erro';
    // Recarrega sessão para exibir o novo e-mail imediatamente
    $logado = $_SESSION['usuario'];
}

// Processa alteração de senha
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'alterar_senha') {
    $ctrl = new UsuarioController();
    $resultado = $ctrl->alterarSenha(
        $idUsuario,
        $_POST['senha_atual'] ?? '',
        $_POST['nova_senha'] ?? '',
        $_POST['confirmar_senha'] ?? ''
    );
    $feedbackMsg = $resultado['sucesso'] ? 'Senha atualizada com sucesso!' : ($resultado['erro'] ?? 'Erro desconhecido.');
    $feedbackTipo = $resultado['sucesso'] ? 'sucesso' : 'erro';
}

$usuario = $modelU->getPerfil($idUsuario);
$relatorio = [];
$vendas = [];
$totalVendas = 0;
$dadosVendedor = null;

// Busca linha em 'vendedor' vinculada ao usuário via chave estrangeira id_usuario
$stmtV = $pdo->prepare(
    "SELECT id_vendedor, nm_vendedor, vl_comissao FROM vendedor WHERE id_usuario = :id"
);
$stmtV->execute(['id' => $idUsuario]);
$rowVendedor = $stmtV->fetch(PDO::FETCH_ASSOC);

if ($rowVendedor) {
    $dadosVendedor = $rowVendedor;
    $vendas = $modelV->listarVendas($rowVendedor['id_vendedor']);
}

// Relatório disponível somente para Administrador
if ($tipo === 'Administrador') {
    $inicio = $_GET['inicio'] ?? null;
    $fim = $_GET['fim'] ?? null;
    $status = $_GET['status'] ?? null;

    $relatorio = $modelO->gerarRelatorio($inicio, $fim, $status);

    foreach ($relatorio as $item) {
        $totalVendas += $item['vl_total'];
    }
}