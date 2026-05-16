<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/norc.css">
    <link rel="stylesheet" href="../assets/css/base.css">
    <title>Novo Orcamento</title>
</head>
<body>
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
            <li><a href="#hero" class="active">Orçamentos</a></li>
            <li><a href="#sobre">Estoque</a></li>
            <li><a href="#pedras">Agenda</a></li>
            <li><a href="#pedras">Produtos</a></li>
            <li><a href="#avaliacoes">Clientes</a></li>
            <li>
                <div>
                    SVG - User
                </div>
            </li>
        </ul>
    </nav>
    <main>
        <h1>Novo Orçamento</h1>
        <div class="form-novoOrcamento">
            <form action="#" method="POST">
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
</body>
</html>
