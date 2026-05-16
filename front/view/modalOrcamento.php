<!-- modais de edição -->
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
                    action="../../back/controller/OrcamentoController.php?acao=atualizar"
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