<?php
require_once __DIR__ . '/../../../back/controller/AuthController.php';
require_once __DIR__ . '/../../../back/config/database.php';

$sql = "SELECT p.id_produto, p.nm_produto, p.ds_produto, c.nm_categoria
        FROM produto p
        LEFT JOIN categoria_produto c ON p.id_categoria = c.id_categoria
        ORDER BY p.id_produto ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);