<h2>Novo Orçamento</h2>
                <form action="../../controllers/orcamento/novo_orcamento.php" method="post">
                    <label for="cliente">Cliente:</label>
                    <input type="text" id="cliente" name="cliente" required>
                    
                    <label for="data">Data:</label>
                    <input type="date" id="data" name="data" required>
                    <label>Endereço: </label>
                    <input type="text" id="endereco" name="endereco" required>
                    <label>Telefone: </label>
                    <input type="tel" id="telefone" name="telefone" required>
                    <label for="descricao">Descrição:</label>
                    <textarea id="descricao" name="descricao" rows="5" required></textarea>

                    <label>Acabamento: </label>
                    <select name="acabamento" id="acabamento" required>
                        <option value="">Selecione</option>
                        <option value="polido">Polido</option>
                        <option value="levigado">Levigado</option>
                        <option value="flameado">Flameado</option>
                        <option value="jateado">Jateado</option>
                    </select>
                    <label>Material: </label>
                    <input type="text" id="material" name="material" required>
                    <label>Cuba: </label>
                    <input type="text" id="cuba" name="cuba" required>
                    <label>Vista: </label>
                    <input type="text" name="vista">
                    <label>Saia: </label>
                    <input type="text" name="saia">
                    <label>Data de Entrega: </label>
                    <input type="date" name="data_entrega" required>


                    <label>Valor Entrada:</label>
                    <input type="number" name="valor_entrada" step="0.01" required>
                    <label>Valor Restante:</label>
                    <input type="number" name="valor_restante" step="0.01" required>
                    <label>Valor Total:</label>
                    <input type="number"  name="valor_total" step="0.01" required>
                    <label>Status:</label>
                    <select name="status" id="status" required>
                        <option value="Aberto">Aberto</option>
                        <option value="Aprovado">Aprovado</option>
                        <option value="Cancelado">Cancelado</option>
                    </select>
                    <button popovertarget="modal" type="submit">Adicionar Orçamento</button>
                </form>