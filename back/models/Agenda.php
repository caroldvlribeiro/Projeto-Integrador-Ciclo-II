<?php
require_once 'Model.php';

/**
 * Model Agenda
 * Gerencia compromissos, visitas e medições (tabela 'agenda').
 */
class Agenda extends Model
{
    protected $id_agenda;
    protected $id_orcamento;
    protected $cd_cliente;
    protected $dt_compromisso;
    protected $hr_compromisso;
    protected $ds_compromisso;
    protected $st_compromisso;

    // Constantes para evitar o uso de "números mágicos" no código
    const STATUS_PENDENTE = 1;
    const STATUS_CONCLUIDO = 0;

    public function __construct(PDO $PDO)
    {
        parent::__construct($PDO, 'agenda');
    }

    // Setters amigáveis
    public function setCliente($id)
    {
        $this->cd_cliente = $id;
    }
    public function setOrcamento($id)
    {
        $this->id_orcamento = $id;
    }
    public function setData($data)
    {
        $this->dt_compromisso = $data;
    }
    public function setHora($hora)
    {
        $this->hr_compromisso = $hora;
    }
    public function setDescricao($desc)
    {
        $this->ds_compromisso = $desc;
    }

    // Altera o status do compromisso para concluído
    public function marcarComoConcluido()
    {
        $this->st_compromisso = self::STATUS_CONCLUIDO;
        return $this->atualizar($this->id_agenda);
    }

    // Lista compromissos de um dia específico
    public function listarPorData($data)
    {
        $sql = "SELECT * FROM {$this->_table} WHERE dt_compromisso = :dt ORDER BY hr_compromisso ASC";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute(['dt' => $data]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Salva um novo compromisso na agenda
    public function salvar(): bool
    {
        $dados = [
            'id_orcamento' => $this->id_orcamento,
            'cd_cliente' => $this->cd_cliente,
            'dt_compromisso' => $this->dt_compromisso,
            'hr_compromisso' => $this->hr_compromisso,
            'ds_compromisso' => $this->ds_compromisso,
            'st_compromisso' => $this->st_compromisso ?? self::STATUS_PENDENTE
        ];

        if ($this->validar($dados)) {
            $sql = "INSERT INTO {$this->_table} 
                    (id_orcamento, cd_cliente, dt_compromisso, hr_compromisso, ds_compromisso, st_compromisso) 
                    VALUES (:id_orcamento, :cd_cliente, :dt_compromisso, :hr_compromisso, :ds_compromisso, :st_compromisso)";
            return $this->executar($sql, $dados);
        }
        return false;
    }

    // Atualiza dados de um compromisso
    public function atualizar(int $id): bool
    {
        $dados = [
            'id' => $id,
            'dt_compromisso' => $this->dt_compromisso,
            'hr_compromisso' => $this->hr_compromisso,
            'ds_compromisso' => $this->ds_compromisso,
            'st_compromisso' => $this->st_compromisso
        ];
        $sql = "UPDATE {$this->_table} SET 
                dt_compromisso = :dt_compromisso, 
                hr_compromisso = :hr_compromisso, 
                ds_compromisso = :ds_compromisso, 
                st_compromisso = :st_compromisso 
                WHERE id_agenda = :id";
        return $this->executar($sql, $dados);
    }
}

?>