<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Adicionar Produto</title>
</head>
<body>
    <header>
        <div class="logo">🪨</div>

        <div class="user">
            <a href="Perfil.php">
                🙍
                <p>Vendedor</p>
            </a>         
        </div>
        <nav>
            <a href="index.php">home</a>
            <a href="Orcamentos.php">Orcamentos</a>
            <a href="Estoque.php">Estoque</a>
        </nav>
    </header>
    <main>
        <h1>Adicionar Produto</h1>
        <div class="form-novoOrcamento">
            <form action="#" method="POST">
                <div class="infoProdutos">
                    <h4>Informações do Produto</h4>
                    <label>Nome do Produto:</label>
                    <input type="text" name="nm_produto" required>
                    <label>Categoria:</label>
                    <select name="id_categoria" required>
                        <option value="">Selecione</option>
                        <option value="1">Ferramentas</option>
                        <option value="2">Insumos de acabamento</option>
                        <option value="3">Fixação e instalação</option>
                        <option value="4">Consumiveis</option>
                    </select>
                    <label>Descrição do Produto: </label>
                    <input type="text" name="ds_produto" required>
                    <label>Valor:</label>
                    <input type="number" name="vl_produto" required>
                </div>
                <button type="submit">Adicionar</button>

            </form>
        </div>
    </main>
</body>
</html>
