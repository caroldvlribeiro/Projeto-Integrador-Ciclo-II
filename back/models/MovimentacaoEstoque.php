<?php
require_once __DIR__ . '/Model.php';

/**
 * Model MovimentacaoEstoque
 * Registra o histórico de entradas e saídas de produtos (tabela 'movimentacao_estoque').
 */
class MovimentacaoEstoque extends Model
{
    protected ?int $id_movimentacao = null;
    protected ?int $id_produto = null;
    protected ?float $qt_movimentacao = null;
    protected ?string $dt_movimentacao = null;
    protected ?string $tp_movimentacao = null;

    public function __construct(PDO $PDO)
    {
        parent::__construct($PDO, 'movimentacao_estoque');
    }

    public function setProduto(int $id): void
    {
        $this->id_produto = $id;
    }
    public function setQuantidade(float $qtd): void
    {
        $this->qt_movimentacao = $qtd;
    }
    public function setTipo(string $tipo): void
    {
        $this->tp_movimentacao = $tipo;
    }

    /**
     * Lista todas as movimentações com o nome do produto (JOIN).
     * Sobrescreve listarTodos() do Model base.
     */
    public function listarTodos(): array
    {
        $sql = "SELECT m.*, p.nm_produto
                FROM {$this->_table} m
                LEFT JOIN produto p ON m.id_produto = p.id_produto
                ORDER BY m.id_movimentacao ASC";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lista o histórico de movimentações de um produto específico.
     */
    public function listarPorProduto(int $idProduto): array
    {
        $sql = "SELECT * FROM {$this->_table} WHERE id_produto = :id ORDER BY id_movimentacao ASC";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute(['id' => $idProduto]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Registra uma nova movimentação (Entrada ou Saída)
public function salvar(): bool
{
    try {

        // Busca estoque atual do produto
        $sqlVerifica = "SELECT qt_estoque 
                         FROM estoque 
                         WHERE id_produto = ?";

        $stmtVerifica = $this->_PDO->prepare($sqlVerifica);
        $stmtVerifica->execute([$this->id_produto]);

        $estoque = $stmtVerifica->fetch(PDO::FETCH_ASSOC);

        $estoqueAtual = $estoque
            ? (int)$estoque['qt_estoque']
            : 0;

        // Validação da quantidade
        if ($this->qt_movimentacao <= 0) {
            $this->_error = "Quantidade deve ser maior que zero.";
            return false;
        }

        // Validações para saída
        if ($this->tp_movimentacao === 'Saída') {

            // Produto ainda não possui estoque
            if (!$estoque) {
                $this->_error = "Produto sem estoque cadastrado.";
                return false;
            }

            // Quantidade insuficiente
            if ($estoqueAtual < $this->qt_movimentacao) {
                $this->_error = "Quantidade insuficiente em estoque. Disponível: " . $estoqueAtual;
                return false;
            }
        }

        // Dados da movimentação
        $dados = [
            'id_produto'      => $this->id_produto,
            'qt_movimentacao' => $this->qt_movimentacao,
            'dt_movimentacao' => date('Y-m-d'),
            'tp_movimentacao' => $this->tp_movimentacao
        ];

        // Insert da movimentação
        $sql = "INSERT INTO {$this->_table}
                (
                    id_produto,
                    qt_movimentacao,
                    dt_movimentacao,
                    tp_movimentacao
                )
                VALUES
                (
                    :id_produto,
                    :qt_movimentacao,
                    :dt_movimentacao,
                    :tp_movimentacao
                )";

        $stmt = $this->_PDO->prepare($sql);

        if (!$stmt->execute($dados)) {
            throw new Exception("Erro ao inserir movimentação.");
        }

        return true;

    } catch (Exception $e) {

        $this->_error = $e->getMessage();
        return false;
    }
}


    // Histórico de movimentação geralmente não é editado, mas o método é obrigatório pela interface
    public function atualizar(int $id): bool
    {
        $this->_error = "Movimentações de estoque não podem ser alteradas por segurança.";
        return false;
    }
}

?>