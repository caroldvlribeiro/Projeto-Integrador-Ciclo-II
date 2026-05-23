<?php
require_once __DIR__ . '/../../../back/controller/AuthController.php';
require_once __DIR__ . '/../../../back/config/database.php';
require_once __DIR__ . '/../../../back/controller/EstoqueController.php';

$controller = new EstoqueController($pdo);
$estoques = $controller->listar();

usort($estoques, function($a, $b) {
    return $a['id_estoque'] <=> $b['id_estoque'];
});