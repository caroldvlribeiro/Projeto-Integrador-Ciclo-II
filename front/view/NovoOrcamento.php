<?php
$paginaAtiva = 'novoorcamento';
$tituloPagina = 'Novo Orçamento - Marmoraria Nova Canaã';
$cssExtra = '../assets/css/norc.css';
include './includes/usuario.php';
require_once __DIR__ . '/../../back/config/database.php';
$pedras     = $pdo->query("SELECT id_pedra, nm_pedra FROM pedra ORDER BY nm_pedra ASC")->fetchAll(PDO::FETCH_ASSOC);
$vendedores = $pdo->query("SELECT id_vendedor, nm_vendedor FROM vendedor ORDER BY nm_vendedor ASC")->fetchAll(PDO::FETCH_ASSOC);
include './includes/layout.php';
?>

<h1>Novo Orçamento</h1>
<div class="form-novoOrcamento">
    <form action="../../back/controller/OrcamentoController.php?acao=criar" method="POST">
        <div class="infoCliente">
            <h4>Informações do Cliente</h4>
            <label>Nome do Cliente:</label>
            <input type="text" name="nm_cliente" placeholder="Ex: João Silva" required >
            <label>Telefone:</label>
            <input type="text" name="cd_telefone" placeholder="Ex: (13) 99999-9999" required>
            <label>Endereço:</label>
            <input type="text" name="nm_endereco" placeholder="Ex: Rua Exemplo, 123" required>
        </div>
        <div class="infoOrcamento">
            <h4>Informações do Orçamento</h4>
            <label>Data do Orçamento:</label>
            <input type="date" name="dt_pedido" value="<?= date('Y-m-d') ?>" required readonly>
            <label>Pedra:</label>
            <select name="id_pedra" required>
                <option value="">Selecione</option>
                <?php foreach ($pedras as $p): ?>
                    <option value="<?= $p['id_pedra'] ?>"><?= htmlspecialchars($p['nm_pedra']) ?></option>
                <?php endforeach; ?>
            </select>
            <label>Descrição do Serviço:</label>
            <input type="text" name="ds_descricao" placeholder="Ex: Bancada de granito para cozinha" required>
            <label>Acabamento:</label>
            <input type="text" name="acabamento" placeholder="Ex: Polido, Levigado, Flameado..." required>
            <label>Vista:</label>
            <input type="text" name="vista" placeholder="Ex: Frontal, Lateral... (opcional)">
            <label>Saia:</label>
            <input type="text" name="saia" placeholder="Ex: 10cm... (opcional)">
            <label>Cuba:</label>
            <input type="text" name="cuba" placeholder="Ex: Cuba oval de embutir... (opcional)">
            <label>Data de Entrega:</label>
            <input type="date" name="dt_entrega" id="dt_entrega">
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
            <input type="number" name="vl_total" placeholder="Ex: 1500.00" required>
            <label>Valor Entrada:</label>
            <input type="number" name="vl_entrada" placeholder="Ex: 500.00 ...(opcional)" >
            <label>Data Pagamento Entrada:</label>
            <input type="date" name="dt_pagamento_entrada" id="dt_pagamento_entrada">
            <label>Valor Saída:</label>
            <input type="number" name="vl_saida" placeholder="Ex: 1000.00 ...(opcional)">
            <label>Data Pagamento Saída:</label>
            <input type="date" name="dt_pagamento_saida">
        </div>
        <div class="infoVendedor">
            <h4>Informações do Vendedor</h4>
            <label>Vendedor:</label>
            <select name="vendedor" required>
                <option value="">Selecione</option>
                <?php foreach ($vendedores as $v): ?>
                    <option value="<?= $v['id_vendedor'] ?>"><?= htmlspecialchars($v['nm_vendedor']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit">Salvar Orçamento</button>
    </form>
</div>

</main>
</div>
</body>

</html>

<script>
    document.getElementById('dt_pagamento_entrada').addEventListener('change', function() {
        const data = new Date(this.value);
        data.setDate(data.getDate() + 20);
        const nova = data.toISOString().split('T')[0];
        document.getElementById('dt_entrega').value = nova;
    });
</script>