<?php
include './includes/filtrosOrcamento.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/orc.css">
    <link rel="stylesheet" href="../assets/css/base.css">
    <title>Orçamentos</title>
</head>
<body>
    <div class="page">
        <nav>
            <div class="nav-logo">
                <div class="isotipo">
                    <svg width="40" height="40" viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg">
                    <rect x="2" y="2" width="52" height="52" fill="none" stroke="#EFF2F4" stroke-width="1.5"/>
                    <rect x="12" y="12" width="52" height="52" fill="none" stroke="#EFF2F4" stroke-width="1.5"/>
                    <rect x="22" y="22" width="52" height="52" fill="none" stroke="#EFF2F4" stroke-width="1.5"/>
                    <rect x="46" y="46" width="14" height="14" fill="#EFF2F4"/>
                    </svg>
                </div>
                <div class="nav-brand">Nova Canaã<small>Marmoraria</small></div>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a class="active" href="Orcamentos.php">Orcamentos</a></li>
                <li><a href="Estoque.php">Estoque</a></li>
                <li>
                    <div>
                    <svg width="40" height="40" viewBox="-44 -44 88 88" xmlns="http://www.w3.org/2000/svg">
                    <clipPath id="cp-dark"><circle r="44"/></clipPath>
                    <circle r="44" fill="#161F39" stroke="#AFC1F8" stroke-width="2"/>
                    <circle cy="-6" r="16" fill="#5C93AA"/>
                    <path d="M-28 38 Q-28 14 0 14 Q28 14 28 38" fill="#5C93AA" clip-path="url(#cp-dark)"/>
                    </svg>
                </div>
                </li>
            </ul>
        </nav>
        <main>
            <div class="bar-orcamentos">
                <a href="NovoOrcamento.php">
                    <h3>NOVO ORÇAMENTOS</h3>
                </a>
                <!--filtro por cliente-->
                <form method="GET" id="clienteForm">
                    <input type="text" name="busca" placeholder="Buscar cliente..." value="<?= $_GET['busca'] ?? '' ?>">
                    <button type="submit">Buscar</button>
                </form>
                <!--filtro por periodo-->
                <form method="GET" id="formPeriodo">
                    <input type="date" name="dataInicio" value="<?= $_GET['dataInicio'] ?? '' ?>">
                    <input type="date" name="dataFim" value="<?= $_GET['dataFim'] ?? '' ?>">        
                    <button type="submit">Filtrar</button>
                </form>
            </div>
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