<?php
require_once 'Model.php';

/**
 * Model MovimentacaoEstoque
 * Registra o histórico de entradas e saídas de produtos (tabela 'movimentacao_estoque').
 */
class MovimentacaoEstoque extends Model
{
    protected $id_movimentacao;
    protected $id_produto;
    protected $qt_movimentacao;
    protected $dt_movimentacao;
    protected $tp_movimentacao; // 'E' para Entrada, 'S' para Saída

    public function __construct(PDO $PDO)
    {
        parent::__construct($PDO, 'movimentacao_estoque');
    }

    // Setters amigáveis
    public function setProduto($id)
    {
        $this->id_produto = $id;
    }
    public function setQuantidade($qtd)
    {
        $this->qt_movimentacao = $qtd;
    }
    public function setTipo($tipo)
    {
        $this->tp_movimentacao = $tipo;
    } // E ou S

    /**
     * Lista o histórico de movimentações de um produto específico.
     */
    public function listarPorProduto($idProduto)
    {
        $sql = "SELECT * FROM {$this->_table} WHERE id_produto = :id ORDER BY dt_movimentacao DESC";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute(['id' => $idProduto]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Registra uma nova movimentação (Entrada ou Saída)
    public function salvar(): bool
    {
        $dados = [
            'id_produto' => $this->id_produto,
            'qt_movimentacao' => $this->qt_movimentacao,
            'dt_movimentacao' => date('Y-m-d H:i:s'),
            'tp_movimentacao' => $this->tp_movimentacao
        ];

        if ($this->validar($dados)) {
            $sql = "INSERT INTO {$this->_table} (id_produto, qt_movimentacao, dt_movimentacao, tp_movimentacao) 
                    VALUES (:id_produto, :qt_movimentacao, :dt_movimentacao, :tp_movimentacao)";
            return $this->executar($sql, $dados);
        }
        return false;
    }

    // Histórico de movimentação geralmente não é editado, mas o método é obrigatório pela interface
    public function atualizar(int $id): bool
    {
        $this->_error = "Movimentações de estoque não podem ser alteradas por segurança.";
        return false;
    }
}

?>