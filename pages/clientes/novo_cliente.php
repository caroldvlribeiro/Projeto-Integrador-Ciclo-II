<?php
session_start();
require_once '../../back/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nm_cliente = trim($_POST['nm_cliente'] ?? '');
    $cd_telefone = trim($_POST['cd_telefone'] ?? '');
    $nm_endereco = trim($_POST['nm_endereco'] ?? '');

    if (empty($nm_cliente)) {
        $_SESSION['message'] = 'Nome do cliente é obrigatório.';
        $_SESSION['message_type'] = 'error';
    } else {
        try {
            $sql = "INSERT INTO cliente (nm_cliente, cd_telefone, nm_endereco) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$nm_cliente, $cd_telefone, $nm_endereco]);

            $_SESSION['message'] = 'Cliente criado com sucesso!';
            $_SESSION['message_type'] = 'success';
        } catch (Exception $e) {
            $_SESSION['message'] = 'Erro ao criar cliente: ' . $e->getMessage();
            $_SESSION['message_type'] = 'error';
        }
    }
}

header('Location: index.php');
exit;
?>
