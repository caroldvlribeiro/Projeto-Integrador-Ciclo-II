<?php

require_once '../../back/config/database.php';
require_once '../../back/models/Orcamento.php';

$model = new Orcamento($pdo);

$orcamentos = $model->listarOrcamentoModal();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/styleOrcamento.css">
    <title>Orçamentos</title>
</head>
<body>
    <div class="page">
        <header>
            <div class="logo">🪨</div>
            <div>
                <h1 id="lista-orcamentos">Orçamentos</h1>
            </div>
            <div class="user">
            <a href="Perfil.php">
                🙍
                <p>Vendedor</p>
            </a>         
        </div>
        <nav>
            <a href="index.php">home</a>
            <a href="Orcamentos.php">Orcamentos</a>
            <a href="Estoque.php">Estoque</a>
        </nav>
        </header>
        <main>
            <a href="NovoOrcamento.php">
            <h3>Novo Orçamento</h3>
        </a>
            <div class="card">
                <table>
                    <!-- tabela que lista todos os orçamentos -->
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Cliente</th>
                            <th>Data do Orçamento</th>
                            <th>Valor Total</th>
                            <th>Data de Entrega</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- loop responsável por mostrar os orçamentos -->
                        <?php foreach($orcamentos as $orcamento): ?>
                            <tr>
                                <td data-label="ID"><?= $orcamento['id_orcamento'] ?></td>

                                <td data-label="Cliente"><?= $orcamento['nm_cliente'] ?? '—' ?></td>

                                <td data-label="Data do Orçamento"><?= date('d/m/Y', strtotime($orcamento['dt_pedido'])) ?> </td>

                                <td data-label="Valor Total">R$
                                    <?= number_format($orcamento['vl_total'], 2, ',', '.') ?></td>

                                <td data-label="Data de Entrega"><?= date('d/m/Y', strtotime($orcamento['dt_entrega'])) ?></td>
                                <td data-label="Status">
                                    <!-- badge do status do orçamento -->
                                    <span class="badge<?= match($orcamento['st_orcamento']) {

                                                    'Aberto'     => 'badge-aberto',
                                                    'Aprovado'   => 'badge-aprovado',
                                                    'Cancelado'  => 'badge-cancelado',
                                                    'Finalizado' => 'badge-finalizado',
                                                    default => 'badge-aberto'
                                                }?>"><?= $orcamento['st_orcamento'] ?>
                                    </span>
                                </td>
                                <td data-label="Ações">
                                    <!-- botão de deletar -->
                                    <a class="btn-delete" href="../../back/controller/OrcamentoController.php?acao=deletar&idOrcamento=<?=$orcamento['id_orcamento'] ?>&cdCliente=<?= $orcamento['cd_cliente'] ?>" onclick="return confirm('Deseja deletar este orçamento?')">🗑 Deletar</a>

                                    <!-- botão que abre modal de edição -->
                                    <a class="btn-editar" href="#editar-<?= $orcamento['id_orcamento'] ?>">✏ Editar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- modais de edição -->
        <?php foreach($orcamentos as $orcamento): ?>

            <div class="modal" id="editar-<?= $orcamento['id_orcamento'] ?>">

                <div class="modal-content">

                    <a class="modal-close" href="#lista-orcamentos">×</a>

                    <h2>Editar Orçamento #<?= $orcamento['id_orcamento'] ?></h2>
                    <form method="POST" action="../../back/controller/OrcamentoController.php?acao=atualizar">
                        <input type="hidden" name="idOrcamento" value="<?= $orcamento['id_orcamento'] ?>">

                        <input type="hidden" name="cdCliente" value="<?= $orcamento['cd_cliente'] ?>" >
                        <label for="valorTotal-<?= $orcamento['id_orcamento'] ?>">Valor Total:</label>
                        <input type="number" step="0.01" name="valorTotal" id="valorTotal-<?= $orcamento['id_orcamento'] ?>" value="<?= $orcamento['vl_total'] ?>" required>

                        <label for="status-<?= $orcamento['id_orcamento'] ?>">Status:</label>
                        <select name="status" id="status-<?= $orcamento['id_orcamento'] ?>">
                            <option value="Aprovado"
                                <?= $orcamento['st_orcamento'] === 'Aprovado' ? 'selected' : '' ?>>Aprovado</option>

                            <option value="Cancelado"<?= $orcamento['st_orcamento'] === 'Cancelado' ? 'selected' : '' ?>> Cancelado</option>

                            <option value="Finalizado" <?= $orcamento['st_orcamento'] === 'Finalizado' ? 'selected' : '' ?>>Finalizado</option>
                        </select>

                        <label for="dtSaida-<?= $orcamento['id_orcamento'] ?>">Data Pagamento Saída:</label>
                        <input type="date" name="dtPagamentoSaida" id="dtSaida-<?= $orcamento['id_orcamento'] ?>">

                        <label for="valorSaida-<?= $orcamento['id_orcamento'] ?>">Valor Saída:</label>

                        <input type="number" step="0.01" name="valorSaida" id="valorSaida-<?= $orcamento['id_orcamento'] ?>">

                        <button type="submit">Salvar Alterações</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
</main>
</body>

</html>