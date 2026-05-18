<?php
require_once 'ItemEstoque.php';

/**
 * Model Produto
 * Gerencia acessórios como cubas e torneiras (tabela 'produto').
 */
class Produto extends ItemEstoque
{
    protected $id_categoria;

    public function __construct(PDO $PDO)
    {
        parent::__construct($PDO, 'produto');
    }

    public function setCategoria($id)
    {
        $this->id_categoria = $id;
    }

    /**
     * Calcula o valor de venda sugerido (ex: 30% de lucro).
     */
    public function calcularVlVenda()
    {
        return $this->vlCompra * 1.3;
    }

    // Salva um novo produto
    public function salvar(): bool
    {
        $dados = [
            'id_categoria' => $this->id_categoria,
            'nm_produto' => $this->nome,
            'ds_produto' => $this->descricao,
            'vl_produto' => $this->vlVenda ?? $this->calcularVlVenda()
        ];

        if ($this->validar($dados)) {
            $sql = "INSERT INTO {$this->_table} (id_categoria, nm_produto, ds_produto, vl_produto) 
                    VALUES (:id_categoria, :nm_produto, :ds_produto, :vl_produto)";
            return $this->executar($sql, $dados);
        }
        return false;
    }

    // Atualiza dados do produto
    public function atualizar(int $id): bool
    {
        $dados = [
            'id' => $id,
            'id_categoria' => $this->id_categoria,
            'nm_produto' => $this->nome,
            'ds_produto' => $this->descricao,
            'vl_produto' => $this->vlVenda
        ];

        if ($this->validar($dados)) {
            $sql = "UPDATE {$this->_table} SET 
                    id_categoria = :id_categoria, 
                    nm_produto = :nm_produto, 
                    ds_produto = :ds_produto, 
                    vl_produto = :vl_produto 
                    WHERE id_produto = :id";
            return $this->executar($sql, $dados);
        }
        return false;
    }
}

?>