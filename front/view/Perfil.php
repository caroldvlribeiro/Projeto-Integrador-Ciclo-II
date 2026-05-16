<?php
include './includes/usuario.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
        <link rel="stylesheet" href="../public/css/stylePerfil.css">
</head>
<body>
    <div class="page">
        <header>
                <div class="logo">🪨</div>
                <div>
                    <h1 id="lista-orcamentos">Orçamentos</h1>
                </div>
                <div class="user">
                <a href="Perfil.php">🙍<p>Vendedor</p>
                </a>         
            </div>
            <nav>
                <a href="index.php">home</a>
                <a href="Orcamentos.php">Orcamentos</a>
                <a href="Estoque.php">Estoque</a>
            </nav>
        </header>
        <main>
            <h3>Perfil</h3>
            <div class="card-info"> 
                <!--tras a tabela do metodo getPerfil-->
                <table>
                    <thead>
                        <?=$usuario?>
                    </thead>
                </table>
            </div>
            <div class="funçoes">
            <h4>Vendas Realizadas:</h4>
            <table>
                    <!-- tabela que lista todos os orçamentos -->
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>ID do Orcamento</th>
                            <th>Data da Venda</th>
                            <th>Valor Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- loop responsável por mostrar os orçamentos -->
                        <?php foreach($vendas as $venda): ?>
                            <tr>
                                <td data-label="ID"><?= $venda['id_venda'] ?></td>

                                <td data-label="ID do Orcamento"><?= $venda['id_orcamento'] ?></td>

                                <td data-label="Data do Orçamento"><?= date('d/m/Y', strtotime($venda['dt_venda'])) ?> </td>

                                <td data-label="Valor Total">R$
                                    <?= number_format($venda ['vl_total'], 2, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table></div>
                <div class="funçoes">
                    <!--Se for um adimistrador ele pode gerar um relatorio das vendas-->
                    <?php if($tipo === 'Administrador'): ?>
                        <a href="Relatorio.php" class="btn-relatorio">
                            Gerar Relatório
                        </a>
                    <?php endif; ?>
                </div>
        </main>
    </div>
</body>
</html>