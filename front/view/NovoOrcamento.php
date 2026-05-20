<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/norc.css">
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <title>Novo Orcamento</title>
</head>
<body>
    <div class="app">
      <header class="header">
        <div class="logo">
            <svg width="36" height="36" viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg">
                <rect x="2"  y="2"  width="52" height="52" fill="none" stroke="#EFF2F4" stroke-width="1.5"/>
                <rect x="12" y="12" width="52" height="52" fill="none" stroke="#EFF2F4" stroke-width="1.5"/>
                <rect x="22" y="22" width="52" height="52" fill="none" stroke="#EFF2F4" stroke-width="1.5"/>
                <rect x="46" y="46" width="14" height="14" fill="#EFF2F4"/>
             </svg>
               <div class="title-header">
                     Nova Canaã
                    <small>Marmoraria</small>
                </div>  
            </div>

            <ul class="nav-links">
                <li><a href="Dashboard.php">Dashboard</a></li>
                <li><a href="Orcamentos.php" class="active">Orçamentos</a></li>
                <li><a href="Estoque.php">Estoque</a></li>
                <li><a href="Agenda.php">Agenda</a></li>
                <li><a href="Produtos.php">Produtos</a></li>
            </ul>

            <div class="user">
                <?= $_SESSION['nm_usuario'] ?>
            </div>
        </header>

        <aside class="sidebar">
            <div class="nav-label">Menu</div>
            <a href="Dashboard.php"        class="nav-item"><i class="ti ti-layout-dashboard"></i> Dashboard</a>
            <a href="Orcamentos.php"  class="nav-item"><i class="ti ti-file-text"></i> Orçamentos</a>
            <a href="NovoOrcamento.php" class="nav-item active"><i class="ti ti-plus"></i> Novo Orçamento</a>
            <a href="Estoque.php"     class="nav-item"><i class="ti ti-stack"></i> Estoque</a>
            <a href="Agenda.php"      class="nav-item"><i class="ti ti-calendar"></i> Agenda</a>
            <a href="Produtos.php"    class="nav-item"><i class="ti ti-package"></i> Produtos</a>
        </aside>
    <main>
        <h1>Novo Orçamento</h1>
        <div class="form-novoOrcamento">
            <form action="../../back/controller/OrcamentoController.php?acao=criar"  method="POST">
                <div class="infoCliente">
                    <h4>Informações do Cliente</h4>
                    <label>Nome do Cliente:</label>
                    <input type="text" name="nm_cliente" required>
                    <label>Telefone:</label>
                    <input type="text" name="cd_telefone" required>
                    <label>Endereco</label>
                    <input type="text" name="nm_endereco" required>
                </div>
                <div class="infoOrcamento">
                    <h4>Informações do Orçamento</h4>
                    <label>Data do Orcamento: </label>
                    <input type="date" name="dt_pedido" required>
                    <label>Pedra:</label>
                    <select name="id_pedra" required>
                        <option value="">Selecione</option>
                        <option value="1">Granito Verde Ubatuba</option>
                        <option value="2">Granito Preto São Gabriel</option>
                        <option value="3">Granito Branco Itaúnas</option>
                    </select>
                    <label>Descrição do Serviço: </label>
                    <input type="text" name="ds_descricao" required>
                    <label>acabamento: </label>
                    <input type="text" name="acabamento" required>
                    <label>Vista: </label>
                    <input type="text" name="vista">
                    <label>Saia:</label>
                    <input type="text" name="saia">
                    <label>Cuba:</label>    
                    <input type="text" name="cuba" >
                    <label>Data de Entrega:</label>
                    <input type="date" name="dt_entrega">
                    <label>Status:</label>
                    <select name="status" required>
                        <option value="">Selecione</option>
                        <option value="Aberto">Aberto</option>
                        <option value="Aprovado">Aprovado</option>
                        <option value="Cancelado">Cancelado</option>
                        <option value="Finalizado">Finalizado</option>
                    </select>
                </div>
                <div class="infoPagamento">
                    <h4>Informações de Pagamento</h4>
                    <label>Valor Total:</label>
                    <input type="number" name="vl_total" required>
                    <label>Valor Entrada:</label>
                    <input type="number" name="vl_entrada">
                    <label>Data Pagamento Entrada:</label>
                    <input type="date" name="dt_pagamento_entrada">
                    <label>Valor Saída:</label>
                    <input type="number" name="vl_saida">
                    <label>Data Pagamento Saída:</label>
                    <input type="date" name="dt_pagamento_saida">
                </div>
                <div class="infoVendedor">
                    <h4>Informações do Vendedor</h4>
                    <label>Vendedor:</label>
                    <select name="vendedor" required>
                        <option value="">Selecione</option>
                        <option value="1">Ricardo Mendes</option>
                        <option value="2">Fernanda Lima</option>
                        <option value="3">Bruno Almeida</option>
                    </select>
                   
                </div>
                <button type="submit">Salvar Orçamento</button>
            </form>
        </div>
    </main>
    </div>
</body>
</html>
