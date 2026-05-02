<?php
require_once 'Model.php';

/**
 * Model CategoriaProduto
 * Gerencia as categorias dos produtos (tabela 'categoria_produto').
 * Ex: Cubas, Torneiras, Acessórios, etc.
 */
class CategoriaProduto extends Model
{
    protected $id_categoria;
    protected $nm_categoria;
    protected $ds_categoria;

    public function __construct(PDO $PDO)
    {
        parent::__construct($PDO, 'categoria_produto');
    }

    // Setters para facilitar o uso no Controller
    public function setNome($nome)
    {
        $this->nm_categoria = $nome;
    }
    public function setDescricao($desc)
    {
        $this->ds_categoria = $desc;
    }

    /**
     * Lista todos os produtos que pertencem a esta categoria.
     */
    public function listarProdutos()
    {
        $sql = "SELECT * FROM produto WHERE id_categoria = :id";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute(['id' => $this->id_categoria]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Insere uma nova categoria no banco
    public function salvar(): bool
    {
        $dados = [
            'nm_categoria' => $this->nm_categoria,
            'ds_categoria' => $this->ds_categoria
        ];

        if ($this->validar($dados)) {
            $sql = "INSERT INTO {$this->_table} (nm_categoria, ds_categoria) 
                    VALUES (:nm_categoria, :ds_categoria)";
            return $this->executar($sql, $dados);
        }
        return false;
    }

    // Atualiza os dados de uma categoria existente
    public function atualizar(int $id): bool
    {
        $dados = [
            'id' => $id,
            'nm_categoria' => $this->nm_categoria,
            'ds_categoria' => $this->ds_categoria
        ];

        if ($this->validar($dados)) {
            $sql = "UPDATE {$this->_table} SET 
                    nm_categoria = :nm_categoria, 
                    ds_categoria = :ds_categoria 
                    WHERE id_categoria = :id";
            return $this->executar($sql, $dados);
        }
        return false;
    }
}

?>