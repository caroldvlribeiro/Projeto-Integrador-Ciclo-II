<?php
require_once 'Model.php';

/**
 * Model Estoque
 * Gerencia a quantidade atual de produtos disponíveis (tabela 'estoque').
 */
class Estoque extends Model
{
    protected $id_estoque;
    protected $id_produto;
    protected $qt_estoque;
    protected $dt_atualizacao;

    public function __construct(PDO $PDO)
    {
        parent::__construct($PDO, 'estoque');
    }

    // Setters para facilitar o uso
    public function setProduto($id)
    {
        $this->id_produto = $id;
    }
    public function setQuantidade($qtd)
    {
        $this->qt_estoque = $qtd;
    }

    /**
     * Busca o saldo atual de um produto específico.
     */
    public function buscarSaldoPorProduto($idProduto)
    {
        $sql = "SELECT qt_estoque FROM {$this->_table} WHERE id_produto = :id";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute(['id' => $idProduto]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ? $res['qt_estoque'] : 0;
    }

    // Registra um novo item no controle de estoque
    public function salvar(): bool
    {
        $dados = [
            'id_produto' => $this->id_produto,
            'qt_estoque' => $this->qt_estoque,
            'dt_atualizacao' => date('Y-m-d H:i:s')
        ];

        if ($this->validar($dados)) {
            $sql = "INSERT INTO {$this->_table} (id_produto, qt_estoque, dt_atualizacao) 
                    VALUES (:id_produto, :qt_estoque, :dt_atualizacao)";
            return $this->executar($sql, $dados);
        }
        return false;
    }

    // Atualiza a quantidade de um item no estoque
    public function atualizar(int $id): bool
    {
        $dados = [
            'id' => $id,
            'qt_estoque' => $this->qt_estoque,
            'dt_atualizacao' => date('Y-m-d H:i:s')
        ];

        if ($this->validar($dados)) {
            $sql = "UPDATE {$this->_table} SET 
                    qt_estoque = :qt_estoque, 
                    dt_atualizacao = :dt_atualizacao 
                    WHERE id_estoque = :id";
            return $this->executar($sql, $dados);
        }
        return false;
    }
}

?>