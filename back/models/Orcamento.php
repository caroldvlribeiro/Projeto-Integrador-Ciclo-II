<?php
require_once 'Model.php';
require_once __DIR__ . '/../interfaces/IRelatorio.php';

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
    protected $cuba;
    protected $vista;
    protected $saia;
    protected $dt_entrega;
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
    public function setCuba($cuba)
    {
        $this->cuba = $cuba;
    }
    public function setVista($vista)
    {
        $this->vista = $vista;
    }
    public function setSaia($saia)
    {
        $this->saia = $saia;
    }
    public function setDtEntrega($data)
    {
        $this->dt_entrega = $data;
    }
    public function setStatus($status)
    {
        $this->st_orcamento = $status;
    }
    public function setDtPedido($data)
    {
        $this->dt_pedido = $data;
    }
    public function getCdCliente()
    {
        return $this->cd_cliente;
    }
    public function getDtPedido()
    {
        return $this->dt_pedido;
    }
    public function getValor()
    {
        return $this->vl_total;
    }
    public function getDescricao()
    {
        return $this->ds_descricao;
    }
    public function getAcabamento()
    {
        return $this->acabamento;
    }
    public function getCuba()
    {
        return $this->cuba;
    }
    public function getVista()
    {
        return $this->vista;
    }
    public function getSaia()
    {
        return $this->saia;
    }
    public function getDtEntrega()
    {
        return $this->dt_entrega;
    }
    public function getStatus()
    {
        return $this->st_orcamento;
    }
    public function getIdPedra()
    {
        return $this->id_pedra;
    }
    


    public function getCd_Orcamento($cd_Cliente){
        $sql = "SELECT id_orcamento FROM orcamento WHERE cd_cliente = :cd_cliente ORDER BY id_orcamento DESC LIMIT 1"; 
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute(['cd_cliente' => $cd_Cliente]);
        return $stmt->fetchColumn();
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
            'nm_cuba' => $this->cuba,
            'vista' => $this->vista,
            'saia' => $this->saia,
            'dt_entrega' => $this->dt_entrega,
            'st_orcamento' => $this->st_orcamento ?? 'Aberto'
        ];
        if($this->validar($dados)){
            $sql = "INSERT INTO orcamento 
            (cd_cliente, dt_pedido, vl_total, ds_descricao, acabamento, id_pedra, nm_cuba, vista, saia, dt_entrega, st_orcamento)
            VALUES (:cd_cliente, :dt_pedido, :vl_total, :ds_descricao, :acabamento, :id_pedra, :nm_cuba, :vista, :saia, :dt_entrega, :st_orcamento)";
        
            return $this->executar($sql, $dados);
        }return false;
    }

    // Atualiza status ou valor do orçamento
    public function atualizar(int $id): bool
{
    $dados = [
        'id' => $id,
        'st_orcamento' => $this->st_orcamento
    ];
    if($this->validar($dados)){
        $sql = "UPDATE {$this->_table} 
                SET
                st_orcamento = :st_orcamento
                WHERE id_orcamento = :id";
        return $this->executar($sql, $dados);
    }return false;
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

    
    public function deletar($id_orcamento): bool
{
    try {

        $this->_PDO->beginTransaction();

        $sql = "DELETE FROM venda WHERE id_orcamento = :id_orcamento";
        $this->executar($sql, [
            'id_orcamento' => $id_orcamento
        ]);

        $sql = "DELETE FROM agenda WHERE id_orcamento = :id_orcamento";
        $this->executar($sql, [
            'id_orcamento' => $id_orcamento
        ]);

        $sql = "DELETE FROM pagamento WHERE id_orcamento = :id_orcamento";
        $this->executar($sql, [
            'id_orcamento' => $id_orcamento
        ]);

        $sql = "DELETE FROM orcamento WHERE id_orcamento = :id_orcamento";
        $this->executar($sql, [
            'id_orcamento' => $id_orcamento
        ]);

        $this->_PDO->commit();

        return true;

    } catch (PDOException $e) {

        $this->_PDO->rollBack();

        echo "Erro ao deletar: " . $e->getMessage();

        return false;
    }
}
public function listarOrcamentoModal(){
    $select = $this->_PDO->prepare("SELECT id_orcamento, cd_cliente, nm_cliente, dt_pedido, vl_total, dt_entrega, st_orcamento From orcamento join cliente Using(cd_cliente) order by dt_pedido");
        $select->execute();
        return $select->fetchAll(PDO::FETCH_ASSOC);
}
}



?>