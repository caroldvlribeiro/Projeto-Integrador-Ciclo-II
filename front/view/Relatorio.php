<?php
include './includes/usuario.php';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório</title>

    <link rel="stylesheet" href="../public/css/stylePerfil.css">
</head>

<body>
<div class="page">
    <header>
        <div class="logo">🪨</div>
            <div>
                <h1>Relatório Geral</h1>
            </div>
        </header>

        <main>
        <!--filtros de busca dos orcamentos-->
            <h2>Filtros</h2>
            <div class="filtros">

                <form method="GET" class="form-filtro">

                    <div>
                        <label>Data Inicial</label>
                        <input type="date" name="inicio">
                    </div>

                    <div>
                        <label>Data Final</label>
                        <input type="date" name="fim">
                    </div>

                    <div>
                        <label>Status</label>

                        <select name="status">

                            <option value="">Todos</option>

                            <option value="Pendente">
                                Pendente
                            </option>

                            <option value="Aprovado">
                                Aprovado
                            </option>

                            <option value="Finalizado">
                                Finalizado
                            </option>
                        </select>
                    </div>
                    <button type="submit">Filtrar</button>
                </form>
            </div>
            <div class="acoes-relatorio">
                <!--abre a função windows de gerar um pdf da pag do navegador-->
                <button onclick="window.print()" class="btn-pdf">Gerar PDF</button>

            </div>
            <div class="cards-relatorio">
                <div class="card">
                    <h3>Total de Registros</h3>

                    <p>
                        <?= count($relatorio) ?>
                    </p>
                </div>

                <div class="card">
                    <h3>Total Vendido</h3>
                    <p>R$ <?= number_format($totalVendas, 2, ',', '.') ?></p>
                </div>
            </div>
            <!--tabela com todos os dados-->
            <table>
                <thead>
                    <tr>
                        <th>Orçamento</th>
                        <th>Cliente</th>
                        <th>Telefone</th>
                        <th>Vendedor</th>
                        <th>Data Pedido</th>
                        <th>Venda</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($relatorio as $item): ?>
                        <tr>
                            <td><?= $item['id_orcamento'] ?></td>
                            <td><?= $item['nm_cliente'] ?></td>
                            <td><?= $item['cd_telefone'] ?></td>
                            <td><?= $item['nm_vendedor'] ?></td>
                            <td><?= date('d/m/Y', strtotime($item['dt_pedido'])) ?></td>
                            <td><?= $item['id_venda'] ?></td>
                            <td>R$ <?= number_format($item['vl_total'], 2, ',', '.') ?></td>
                            <td><?= $item['st_orcamento'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
</div>
</body>
</html>