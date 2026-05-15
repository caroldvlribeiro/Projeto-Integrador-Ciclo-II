
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Criar Orçamento</title>
</head>
<body>

    <h2>Novo Orçamento</h2>

    <form action="../controller/OrcamentoController.php?acao=criar" method="POST">
        <!-- dados do cliente-->
        <label>Nome do Cliente:</label><br>
        <input type="text" name="nmCliente" required><br><br>

        <label>Telefone:</label><br>
        <input type="number" name="nrTelefone"><br><br>

        <label>Endereço:</label><br>
        <input type="text" name="endereco"><br><br>
        <!--dados do orcamento-->
        <label>Data do Pedido:</label><br>
        <input type="date" name="dtPedido"><br><br>

        <label>Descrição:</label><br>
        <textarea name="descricao" placeholder="Descrição do orcamento"></textarea><br><br>

        <label>Acabamento:</label><br>
        <select name="idAcabamento">
            <option value="Polido">Polido</option>
            <option value="Escovado">Escovado</option>
        </select><br><br>

        <label>Vista</label>
        <input type="text" name="vista"><br><br>

        <label>Saia</label><br>
        <input type="text" name="saia"><br><br>

        <label>Cuba</label><br><input type="radio" name="cuba" value="Sim"> Sim<br>
        <input type="radio" name="cuba" value="Não"> Não<br><br>
        <input type="text" name="modeloCuba" placeholder="Modelo da Cuba"><br><br>
        
        <label>Pedra</label><br>
        <select name="idPedra">
            <option value="1">Granito</option>
            <option value="2">Mármore</option>
            <option value="3">Quartzo</option>
        </select><br><br>

        <label>Data de entrega:</label>
        <input type="date" name="dtEntrega"><br><br>

        <label>Status:</label><br>
        <select name="status">
            <option value="Aprovado">Aprovado</option>
            <option value="Cancelado">Cancelado</option>
            <option value="Finalizado">Finalizado</option>
        </select><br><br>
        <!--dados do pagamento-->
        <label>Valor Total:</label><br>
        <input type="number" step="0.01" name="valorTotal" required><br><br>

        <label>Data de Pagamento da Entrada:</label>
        <input type="date" name="dtPagamentoEntrada"><br><br>

        <label>Valor da Entrada:</label><br>
        <input type="number" step="0.01" name="valorEntrada"><br><br>

        <label>Data de Pagamento de Saida:</label>
        <input type="date" name="dtPagamentoSaida"><br><br>

        <label>Valor de Saida:</label><br>
        <input type="number" step="0.01" name="valorSaida"><br><br>
        
        <!--dados do vendedor-->
        <label>Vendedor</label><br>
        <select name="vendedor">
            <option value="1">Vendedor 1</option>
            <option value="2">Vendedor 2</option>
            <option value="3">Vendedor 3</option>
        </select><br><br>
        <button type="submit">Criar Orçamento</button>
    </form>
</body>
</html>