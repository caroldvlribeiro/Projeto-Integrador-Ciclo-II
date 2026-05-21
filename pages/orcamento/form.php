<?php
require_once __DIR__ . '/../../back/config/database.php';
require_once __DIR__ . '/../../back/controller/OrcamentoController.php';
require_once __DIR__ . '/../../back/models/Orcamento.php';

$orcamento = null;
$modo = 'novo';

// Se é edição, busca o orçamento
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM orcamento WHERE id_orcamento = ?");
    $stmt->execute([$id]);
    $orcamento = $stmt->fetch(PDO::FETCH_ASSOC);
    $modo = 'editar';
}

// Buscar clientes para dropdown
$stmt = $conn->prepare("SELECT cd_cliente, nm_cliente FROM cliente ORDER BY nm_cliente");
$stmt->execute();
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Buscar pedras para dropdown
$stmt = $conn->prepare("SELECT id_pedra, nm_pedra FROM pedra ORDER BY nm_pedra");
$stmt->execute();
$pedras = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $modo === 'novo' ? 'Novo' : 'Editar' ?> Orçamento · Nova Canaã</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
<div class="app">

    <header class="header">
        <div class="logo">
            Nova Canaã
            <small>Marmoraria</small>
        </div>
        <div class="user">&#9679; Sistema Interno</div>
    </header>

    <aside class="sidebar">
        <div class="nav-label">Cadastros</div>
        <a href="../categoria_produto/index.php" class="nav-item">Categorias</a>
        <a href="../produto/index.php" class="nav-item">Produtos</a>
        <a href="../clientes/index.php" class="nav-item">Clientes</a>

        <div class="nav-label" style="margin-top:20px;">Operação</div>
        <a href="../estoque/index.php" class="nav-item">Estoque</a>
        <a href="../movimentacao_estoque/index.php" class="nav-item">Movimentação</a>
        <a href="index.php" class="nav-item active">Orçamentos</a>
    </aside>

    <main class="main">

        <div class="page-header">
            <div>
                <div class="page-eyebrow">Operação</div>
                <h1 class="page-title"><?= $modo === 'novo' ? 'Novo Orçamento' : 'Editar Orçamento' ?></h1>
                <p class="page-desc"><?= $modo === 'novo' ? 'Preencha os dados para criar um novo orçamento' : 'Atualize os dados do orçamento' ?></p>
            </div>
        </div>

        <div class="card" style="max-width:600px;">
            <form id="formOrcamento" method="POST" action="form_processing.php">
                <input type="hidden" name="id" id="id" value="<?= $orcamento['id_orcamento'] ?? '' ?>">

                <div class="form-group">
                    <label class="form-label" for="cd_cliente">Cliente *</label>
                    <select class="form-input" id="cd_cliente" name="cd_cliente" required>
                        <option value="">Selecione um cliente</option>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?= $cliente['cd_cliente'] ?>" <?= ($orcamento && $orcamento['cd_cliente'] == $cliente['cd_cliente']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cliente['nm_cliente']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="dt_pedido">Data do Pedido</label>
                    <input class="form-input" type="date" id="dt_pedido" name="dt_pedido" value="<?= $orcamento['dt_pedido'] ?? date('Y-m-d') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="vl_total">Valor Total (R$) *</label>
                    <input class="form-input" type="number" id="vl_total" name="vl_total" step="0.01" min="0" required value="<?= htmlspecialchars($orcamento['vl_total'] ?? '') ?>" placeholder="0,00">
                </div>

                <div class="form-group">
                    <label class="form-label" for="id_pedra">Tipo de Pedra</label>
                    <select class="form-input" id="id_pedra" name="id_pedra">
                        <option value="">Nenhuma</option>
                        <?php foreach ($pedras as $pedra): ?>
                            <option value="<?= $pedra['id_pedra'] ?>" <?= ($orcamento && $orcamento['id_pedra'] == $pedra['id_pedra']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($pedra['nm_pedra']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="acabamento">Acabamento</label>
                    <input class="form-input" type="text" id="acabamento" name="acabamento" maxlength="200" value="<?= htmlspecialchars($orcamento['acabamento'] ?? '') ?>" placeholder="Ex: Polido, Espelhado, Jato de Areia">
                </div>

                <div class="form-group">
                    <label class="form-label" for="ds_descricao">Descrição</label>
                    <textarea class="form-textarea" id="ds_descricao" name="ds_descricao" placeholder="Detalhes do orçamento"><?= htmlspecialchars($orcamento['ds_descricao'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="st_orcamento">Status</label>
                    <select class="form-input" id="st_orcamento" name="st_orcamento">
                        <option value="Aberto" <?= ($orcamento && $orcamento['st_orcamento'] === 'Aberto') ? 'selected' : '' ?>>Aberto</option>
                        <option value="Aprovado" <?= ($orcamento && $orcamento['st_orcamento'] === 'Aprovado') ? 'selected' : '' ?>>Aprovado</option>
                        <option value="Cancelado" <?= ($orcamento && $orcamento['st_orcamento'] === 'Cancelado') ? 'selected' : '' ?>>Cancelado</option>
                        <option value="Finalizado" <?= ($orcamento && $orcamento['st_orcamento'] === 'Finalizado') ? 'selected' : '' ?>>Finalizado</option>
                    </select>
                </div>

                <div class="modal-actions">
                    <a href="index.php" class="btn btn-ghost">← Voltar</a>
                    <button type="submit" class="btn btn-primary">💾 Salvar</button>
                </div>
            </form>
        </div>

    </main>
</div>

</body>
</html>
