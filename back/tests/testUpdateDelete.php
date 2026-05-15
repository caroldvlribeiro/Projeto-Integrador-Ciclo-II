<?php

require_once '../config/database.php';
require_once '../models/Orcamento.php';

$model = new Orcamento($pdo);

$orcamentos = $model->listarTodos();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Orçamentos</title>

    <style>

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .page {
            max-width: 1200px;
            margin: auto;
        }

        header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
        }

        .logo {
            font-size: 40px;
        }

        .card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #fafafa;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
        }

        .badge-aberto {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-aprovado {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-cancelado {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-finalizado {
            background: #ddd6fe;
            color: #5b21b6;
        }

        .btn-delete,
        .btn-editar {
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 14px;
            display: inline-block;
        }

        .btn-delete {
            background: #ef4444;
            color: white;
        }

        .btn-editar {
            background: #3b82f6;
            color: white;
        }

        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.5);
            justify-content: center;
            align-items: center;
        }

        .modal:target {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 24px;
            border-radius: 12px;
            width: 400px;
            position: relative;
        }

        .modal-close {
            position: absolute;
            right: 16px;
            top: 10px;
            text-decoration: none;
            color: black;
            font-size: 22px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        input,
        select,
        button {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        button {
            background: #10b981;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

    </style>

</head>

<body>

    <div class="page">

        <header>

            <div class="logo">
                🪨
            </div>

            <div>

                <h1 id="lista-orcamentos">
                    Orçamentos
                </h1>

                <p>
                    Gerencie e acompanhe os orçamentos cadastrados
                </p>

            </div>

        </header>

        <div class="card">

            <table>

                <thead>

                    <tr>

                        <th>#ID</th>
                        <th>Cliente</th>
                        <th>Valor Total</th>
                        <th>Status</th>
                        <th>Ações</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach($orcamentos as $orcamento): ?>

                        <tr>

                            <td data-label="ID">

                                <?= $orcamento['id_orcamento'] ?>

                            </td>

                            <td data-label="Cliente">

                                <?= $orcamento['nm_cliente'] ?? '—' ?>

                            </td>

                            <td data-label="Valor Total">

                                R$
                                <?= number_format($orcamento['vl_total'], 2, ',', '.') ?>

                            </td>

                            <td data-label="Status">

                                <span
                                    class="
                                        badge
                                        <?=
                                            match($orcamento['st_orcamento']) {

                                                'Aberto'     => 'badge-aberto',
                                                'Aprovado'   => 'badge-aprovado',
                                                'Cancelado'  => 'badge-cancelado',
                                                'Finalizado' => 'badge-finalizado',

                                                default => 'badge-aberto'
                                            }
                                        ?>
                                    "
                                >

                                    <?= $orcamento['st_orcamento'] ?>

                                </span>

                            </td>

                            <td data-label="Ações">

                                <a
                                    class="btn-delete"
                                    href="../controller/OrcamentoController.php?acao=deletar&idOrcamento=<?= $orcamento['id_orcamento'] ?>&cdCliente=<?= $orcamento['cd_cliente'] ?>"
                                    onclick="return confirm('Deseja deletar este orçamento?')"
                                >
                                    🗑 Deletar
                                </a>

                                <a
                                    class="btn-editar"
                                    href="#editar-<?= $orcamento['id_orcamento'] ?>"
                                >
                                    ✏ Editar
                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

    <?php foreach($orcamentos as $orcamento): ?>

        <div
            class="modal"
            id="editar-<?= $orcamento['id_orcamento'] ?>"
        >

            <div class="modal-content">

                <a
                    class="modal-close"
                    href="#lista-orcamentos"
                >
                    ×
                </a>

                <h2>
                    Editar Orçamento #<?= $orcamento['id_orcamento'] ?>
                </h2>

                <form
                    method="POST"
                    action="../controller/OrcamentoController.php?acao=atualizar"
                >

                    <input
                        type="hidden"
                        name="idOrcamento"
                        value="<?= $orcamento['id_orcamento'] ?>"
                    >

                    <input
                        type="hidden"
                        name="cdCliente"
                        value="<?= $orcamento['cd_cliente'] ?>"
                    >

                    <label for="valorTotal-<?= $orcamento['id_orcamento'] ?>">
                        Valor Total:
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="valorTotal"
                        id="valorTotal-<?= $orcamento['id_orcamento'] ?>"
                        value="<?= $orcamento['vl_total'] ?>"
                        required
                    >

                    <label for="status-<?= $orcamento['id_orcamento'] ?>">
                        Status:
                    </label>

                    <select
                        name="status"
                        id="status-<?= $orcamento['id_orcamento'] ?>"
                    >

                        <option
                            value="Aberto"
                            <?= $orcamento['st_orcamento'] === 'Aberto' ? 'selected' : '' ?>
                        >
                            Aberto
                        </option>

                        <option
                            value="Aprovado"
                            <?= $orcamento['st_orcamento'] === 'Aprovado' ? 'selected' : '' ?>
                        >
                            Aprovado
                        </option>

                        <option
                            value="Cancelado"
                            <?= $orcamento['st_orcamento'] === 'Cancelado' ? 'selected' : '' ?>
                        >
                            Cancelado
                        </option>

                        <option
                            value="Finalizado"
                            <?= $orcamento['st_orcamento'] === 'Finalizado' ? 'selected' : '' ?>
                        >
                            Finalizado
                        </option>

                    </select>

                    

                    <label for="dtSaida-<?= $orcamento['id_orcamento'] ?>">
                        Data Pagamento Saída:
                    </label>

                    <input
                        type="date"
                        name="dtPagamentoSaida"
                        id="dtSaida-<?= $orcamento['id_orcamento'] ?>"
                    >

                    <label for="valorSaida-<?= $orcamento['id_orcamento'] ?>">
                        Valor Saída:
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="valorSaida"
                        id="valorSaida-<?= $orcamento['id_orcamento'] ?>"
                    >

                    <button type="submit">
                        Salvar Alterações
                    </button>

                </form>

            </div>

        </div>

    <?php endforeach; ?>

</body>

</html>