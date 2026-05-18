<?php
session_start();
require_once '../../back/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cd_cliente = (int)($_POST['cd_cliente'] ?? 0);
    $nm_cliente = trim($_POST['nm_cliente'] ?? '');
    $cd_telefone = trim($_POST['cd_telefone'] ?? '');
    $nm_endereco = trim($_POST['nm_endereco'] ?? '');

    if (empty($nm_cliente)) {
        $_SESSION['message'] = 'Nome do cliente é obrigatório.';
        $_SESSION['message_type'] = 'error';
    } else if ($cd_cliente <= 0) {
        $_SESSION['message'] = 'Cliente inválido.';
        $_SESSION['message_type'] = 'error';
    } else {
        try {
            $sql = "UPDATE cliente SET nm_cliente = ?, cd_telefone = ?, nm_endereco = ? WHERE cd_cliente = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$nm_cliente, $cd_telefone, $nm_endereco, $cd_cliente]);

            $_SESSION['message'] = 'Cliente atualizado com sucesso!';
            $_SESSION['message_type'] = 'success';
        } catch (Exception $e) {
            $_SESSION['message'] = 'Erro ao atualizar cliente: ' . $e->getMessage();
            $_SESSION['message_type'] = 'error';
        }
    }
}

header('Location: index.php');
exit;
?>
