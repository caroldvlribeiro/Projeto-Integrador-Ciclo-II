<?php
require_once __DIR__ . '/../../back/config/database.php';
require_once __DIR__ . '/../../back/models/Orcamento.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $id_cliente = $_POST['id_cliente'] ?? null;
    $dt_pedido = $_POST['dt_pedido'] ?? null;
    $nr_orcamento = $_POST['nr_orcamento'] ?? null;
    $vl_total = $_POST['vl_total'] ?? null;
    $id_pedra = $_POST['id_pedra'] ?? null;
    $ds_acabamento = $_POST['ds_acabamento'] ?? null;
    $ds_descricao = $_POST['ds_descricao'] ?? null;
    $st_status = $_POST['st_status'] ?? 'Aberto';

    $orcamento = new Orcamento($conn);

    if ($id) {
        // Atualizar
        $orcamento->setValor($vl_total);
        $orcamento->setDescricao($ds_descricao);
        $orcamento->setAcabamento($ds_acabamento);
        $orcamento->setStatus($st_status);

        if ($orcamento->atualizar($id)) {
            $_SESSION['mensagem'] = 'Orçamento atualizado com sucesso!';
            $_SESSION['tipo_mensagem'] = 'success';
        } else {
            $_SESSION['mensagem'] = 'Erro ao atualizar orçamento.';
            $_SESSION['tipo_mensagem'] = 'error';
        }
    } else {
        // Criar novo
        if (!$id_cliente || !$vl_total) {
            $_SESSION['mensagem'] = 'Cliente e Valor Total são obrigatórios!';
            $_SESSION['tipo_mensagem'] = 'error';
            header('Location: form.php');
            exit;
        }

        $orcamento->setCliente($id_cliente);
        $orcamento->setDtPedido($dt_pedido);
        $orcamento->setValor($vl_total);
        $orcamento->setDescricao($ds_descricao);
        $orcamento->setAcabamento($ds_acabamento);
        $orcamento->setPedra($id_pedra);
        $orcamento->setStatus($st_status);

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
