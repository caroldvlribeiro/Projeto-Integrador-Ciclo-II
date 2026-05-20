<?php
require_once __DIR__ . '/../../back/config/database.php';
require_once __DIR__ . '/../../back/models/Orcamento.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $cd_cliente = $_POST['cd_cliente'] ?? null;
    $dt_pedido = $_POST['dt_pedido'] ?? null;
    $vl_total = $_POST['vl_total'] ?? null;
    $id_pedra = $_POST['id_pedra'] ?? null;
    $acabamento = $_POST['acabamento'] ?? null;
    $ds_descricao = $_POST['ds_descricao'] ?? null;
    $st_orcamento = $_POST['st_orcamento'] ?? 'Aberto';

    $orcamento = new Orcamento($conn);

    if ($id) {
        // Atualizar
        $orcamento->setValor($vl_total);
        $orcamento->setDescricao($ds_descricao);
        $orcamento->setAcabamento($acabamento);
        $orcamento->setStatus($st_orcamento);

        if ($orcamento->atualizar($id)) {
            $_SESSION['mensagem'] = 'Orçamento atualizado com sucesso!';
            $_SESSION['tipo_mensagem'] = 'success';
        } else {
            $_SESSION['mensagem'] = 'Erro ao atualizar orçamento.';
            $_SESSION['tipo_mensagem'] = 'error';
        }
    } else {
        // Criar novo
        if (!$cd_cliente || !$vl_total) {
            $_SESSION['mensagem'] = 'Cliente e Valor Total são obrigatórios!';
            $_SESSION['tipo_mensagem'] = 'error';
            header('Location: form.php');
            exit;
        }

        $orcamento->setCliente($cd_cliente);
        $orcamento->setDtPedido($dt_pedido);
        $orcamento->setValor($vl_total);
        $orcamento->setDescricao($ds_descricao);
        $orcamento->setAcabamento($acabamento);
        $orcamento->setPedra($id_pedra);
        $orcamento->setStatus($st_orcamento);

        if ($orcamento->salvar()) {
            $_SESSION['mensagem'] = 'Orçamento criado com sucesso!';
            $_SESSION['tipo_mensagem'] = 'success';
        } else {
            $_SESSION['mensagem'] = 'Erro ao criar orçamento.';
            $_SESSION['tipo_mensagem'] = 'error';
        }
    }

    header('Location: index.php');
    exit;
}

// Se não for POST, redireciona para form.php
header('Location: form.php');
exit;
?>
