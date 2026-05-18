<?php
require_once 'RegistroFinanceiro.php';

/**
 * Model Venda
 * Gerencia as vendas finalizadas (tabela 'venda').
 */
class Venda extends RegistroFinanceiro
{

    protected $id_venda;
    protected $id_vendedor;
    protected $dt_venda;

    public function __construct(PDO $PDO)
    {
        parent::__construct($PDO, 'venda');
    }

    /**
     * Retorna o valor total da venda.
     */
    public function calcularValor(): float
    {
        return (float) $this->vlTotal;
    }

    // Setters amigáveis
    public function setVendedor($id)
    {
        $this->id_vendedor = $id;
    }
    public function setOrcamento($id)
    {
        $this->idOrcamento = $id;
    }
    public function setValorTotal($valor)
    {
        $this->vlTotal = $valor;
    }
    public function setDataVenda($data)
    {
        $this->dt_venda = $data;
    }

    /**
     * Lista todas as vendas de um vendedor específico.
     */
    public function listarPorVendedor($idVendedor)
    {
        $sql = "SELECT * FROM {$this->_table} WHERE id_vendedor = :id";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute(['id' => $idVendedor]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Registra uma nova venda no banco
    public function salvar(): bool
    {
        $dados = [
            'id_orcamento' => $this->idOrcamento,
            'id_vendedor' => $this->id_vendedor,
            'dt_venda' => $this->dt_venda ?? date('Y-m-d'),
            'vl_total' => $this->vlTotal
        ];

        if ($this->validar($dados)) {
            $sql = "INSERT INTO {$this->_table} 
                    (id_orcamento, id_vendedor, dt_venda, vl_total) 
                    VALUES (:id_orcamento, :id_vendedor, :dt_venda, :vl_total)";
            return $this->executar($sql, $dados);
        }
        return false;
    }

    // Atualiza o valor de uma venda existente
    public function atualizar(int $id): bool
    {
        $dados = [
            'id' => $id,
            'vl_total' => $this->vlTotal
        ];
        $sql = "UPDATE {$this->_table} SET vl_total = :vl_total WHERE id_venda = :id";
        return $this->executar($sql, $dados);
    }
}

?>