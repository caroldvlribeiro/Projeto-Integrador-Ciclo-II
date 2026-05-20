<?php
require_once __DIR__ . '/../../../back/controller/AuthController.php';
require_once __DIR__ . '/../../../back/config/database.php';
require_once __DIR__ . '/../../../back/models/Usuario.php';
require_once __DIR__ . '/../../../back/models/Vendedor.php';
require_once __DIR__ . '/../../../back/models/Orcamento.php';

$auth = new AuthController();

// Logout para limpar sessão e redirecionar para login usado nas telas Dashboard e de Perfil 
if (isset($_GET['acao']) && $_GET['acao'] === 'logout') {
    $auth->logout();
}

// Garante que sessão está ativa e usuário está logado
$auth->verificarSessao();

$logado = $_SESSION['usuario'];
$idUsuario = $logado['id_usuario'];
$tipo = $logado['tp_usuario']; // 'Administrador' ou 'Vendedor'

$modelU = new Usuario($pdo);
$modelV = new Vendedor($pdo);
$modelO = new Orcamento($pdo);

// Perfil: busca pelo id_usuario da sessão (não mais hardcoded)
$usuario = $modelU->getPerfil($idUsuario);

$relatorio = [];
$vendas = [];
$totalVendas = 0;

if ($tipo === 'Administrador' || $tipo === 'Vendedor') {
    // Descobre o id_vendedor a partir do id_usuario (JOIN vendedor → usuario)
    $stmt = $pdo->prepare("SELECT id_vendedor FROM vendedor WHERE id_usuario = :id");
    $stmt->execute(['id' => $idUsuario]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $idVendedor = $row['id_vendedor'];
        $vendas = $modelV->listarVendas($idVendedor);
    }
}

if ($tipo === 'Administrador') {
    $inicio = $_GET['inicio'] ?? null;
    $fim = $_GET['fim'] ?? null;
    $status = $_GET['status'] ?? null;

    $relatorio = $modelO->gerarRelatorio($inicio, $fim, $status);

    foreach ($relatorio as $item) {
        $totalVendas += $item['vl_total'];
    }
}