<?php
session_start();
require_once '../../back/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cd_cliente = (int)($_POST['cd_cliente'] ?? 0);

    if ($cd_cliente <= 0) {
        $_SESSION['message'] = 'Cliente inválido.';
        $_SESSION['message_type'] = 'error';
    } else {
        try {
            $sql = "DELETE FROM cliente WHERE cd_cliente = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$cd_cliente]);

            $_SESSION['message'] = 'Cliente deletado com sucesso!';
            $_SESSION['message_type'] = 'success';
        } catch (Exception $e) {
            $_SESSION['message'] = 'Erro ao deletar cliente: ' . $e->getMessage();
            $_SESSION['message_type'] = 'error';
        }
    }
}

header('Location: index.php');
exit;
?>
