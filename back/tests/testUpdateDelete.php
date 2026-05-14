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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orçamentos</title>
    <style>

.modal {
    display: none;
}

.modal:target {
    display: block;
}

</style>
</head>

<body>

    <div class="page">

        <header>
            <div class="logo">🪨</div>

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

            <table border="1">

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
                                        <?= $orcamento['st_orcamento'] === 'Aberto'
                                            ? 'badge-Aprovado'
                                            : 'badge-Cancelado'
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
                            <?= $orcamento['st_orcamento'] === 'Aberto'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            Aberto
                        </option>

                        <option
                            value="Fechado"
                            <?= $orcamento['st_orcamento'] === 'Fechado'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            Fechado
                        </option>

                    </select>

                    <label for="dtEntrada-<?= $orcamento['id_orcamento'] ?>">
                        Data Pagamento Entrada:
                    </label>

                    <input
                        type="date"
                        name="dtPagamentoEntrada"
                        id="dtEntrada-<?= $orcamento['id_orcamento'] ?>"
                    >

                    <label for="valorEntrada-<?= $orcamento['id_orcamento'] ?>">
                        Valor Entrada:
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="valorEntrada"
                        id="valorEntrada-<?= $orcamento['id_orcamento'] ?>"
                    >

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