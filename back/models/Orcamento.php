<?php
require_once 'Model.php';
require_once '../interfaces/IRelatorio.php';

/**
 * Model Orcamento
 * O coração do sistema. Gerencia pedidos, status e gera relatórios.
 */
class Orcamento extends Model implements IRelatorio
{
    protected $cd_cliente;
    protected $dt_pedido;
    protected $vl_total;
    protected $ds_descricao;
    protected $acabamento;
    protected $id_pedra;
    protected $st_orcamento; // Status: Aberto, Aprovado, Cancelado, Finalizado

    public function __construct(PDO $PDO)
    {
        parent::__construct($PDO, 'orcamento');
    }

    // Mapeamento de Setters para facilitar o uso no Controller
    public function setCliente($id)
    {
        $this->cd_cliente = $id;
    }
    public function setPedra($id)
    {
        $this->id_pedra = $id;
    }
    public function setValor($valor)
    {
        $this->vl_total = $valor;
    }
    public function setDescricao($desc)
    {
        $this->ds_descricao = $desc;
    }
    public function setAcabamento($acab)
    {
        $this->acabamento = $acab;
    }
    public function setStatus($status)
    {
        $this->st_orcamento = $status;
    }
    public function setDtPedido($data)
    {
        $this->dt_pedido = $data;
    }

    // Cria um novo orçamento (padrão: Aberto)
    public function salvar(): bool
    {
        $dados = [
            'cd_cliente' => $this->cd_cliente,
            'dt_pedido' => $this->dt_pedido ?? date('Y-m-d'),
            'vl_total' => $this->vl_total,
            'ds_descricao' => $this->ds_descricao,
            'acabamento' => $this->acabamento,
            'id_pedra' => $this->id_pedra,
            'st_orcamento' => $this->st_orcamento ?? 'Aberto'
        ];

        if ($this->validar($dados)) {
            $sql = "INSERT INTO {$this->_table} (cd_cliente, dt_pedido, vl_total, ds_descricao, acabamento, id_pedra, st_orcamento) 
                    VALUES (:cd_cliente, :dt_pedido, :vl_total, :ds_descricao, :acabamento, :id_pedra, :st_orcamento)";
            return $this->executar($sql, $dados);
        }
        return false;
    }

    // Atualiza status ou valor do orçamento
    public function atualizar(int $id): bool
    {
        $dados = [
            'id' => $id,
            'vl_total' => $this->vl_total,
            'st_orcamento' => $this->st_orcamento,
            'ds_descricao' => $this->ds_descricao
        ];

        $sql = "UPDATE {$this->_table} SET 
                vl_total = :vl_total, 
                st_orcamento = :st_orcamento, 
                ds_descricao = :ds_descricao 
                WHERE id_orcamento = :id";
        return $this->executar($sql, $dados);
    }

    // --- IMPLEMENTAÇÃO DA INTERFACE IRelatorio ---

    public function gerarRelatorio(): array
    {
        return $this->listarTodos();
    }

    public function filtrarPorPeriodo(string $ini, string $fim): array
    {
        $sql = "SELECT * FROM {$this->_table} WHERE dt_pedido BETWEEN :ini AND :fim";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute(['ini' => $ini, 'fim' => $fim]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function exportar(string $formato): string
    {
        return "Relatório de Orçamentos exportado em formato: $formato";
    }
}

?>