<?php
require_once 'Model.php';
require_once '../interfaces/IRelatorio.php';

class Orcamento extends Model implements IRelatorio
{
    private $idOrcamento;
    private $cdCliente;
    private $dtPedido;
    private $vlTotal;
    private $dsDescricao;
    private $stOrcamento; // enum: aberto, aprovado, cancelado, finalizado

    public function __construct(PDO $PDO)
    {
        parent::__construct($PDO, 'orcamentos');
    }

    // GETTERS E SETTERS
    public function getIdOrcamento()
    {
        return $this->idOrcamento;
    }
    public function setIdOrcamento($id)
    {
        $this->idOrcamento = $id;
    }
    public function getVlTotal()
    {
        return $this->vlTotal;
    }
    public function setVlTotal($vl)
    {
        $this->vlTotal = $vl;
    }

    // MÉTODOS DO DIAGRAMA
    public function calcularValor(): float
    {
        // Lógica para somar itens do orçamento (se houver tabela relacionada)
        return (float) $this->vlTotal;
    }

    public function aprovar(): bool
    {
        $this->stOrcamento = 'aprovado';
        return $this->atualizar($this->idOrcamento);
    }

    public function cancelar(): bool
    {
        $this->stOrcamento = 'cancelado';
        return $this->atualizar($this->idOrcamento);
    }

    public function finalizar(): bool
    {
        $this->stOrcamento = 'finalizado';
        return $this->atualizar($this->idOrcamento);
    }

    public function listarPorCliente($id)
    {
        $sql = "SELECT * FROM {$this->_table} WHERE cdCliente = :id";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarAbertos()
    {
        $sql = "SELECT * FROM {$this->_table} WHERE stOrcamento = 'aberto'";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // IMPLEMENTAÇÃO IRelatorio
    public function gerarRelatorio(): array
    {
        return $this->listarTodos();
    }

    public function filtrarPorPeriodo(string $dataInicio, string $dataFim): array
    {
        $sql = "SELECT * FROM {$this->_table} WHERE dtPedido BETWEEN :ini AND :fim";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute(['ini' => $dataInicio, 'fim' => $dataFim]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function exportar(string $formato): string
    {
        return "Relatório exportado em: " . $formato;
    }

    // CRUD
    public function salvar(): bool
    {
        $dados = [
            'cdCliente' => $this->cdCliente,
            'dtPedido' => $this->dtPedido,
            'vlTotal' => $this->vlTotal,
            'dsDescricao' => $this->dsDescricao,
            'stOrcamento' => 'aberto'
        ];
        if ($this->validar($dados)) {
            $sql = "INSERT INTO {$this->_table} (cdCliente, dtPedido, vlTotal, dsDescricao, stOrcamento) 
                    VALUES (:cdCliente, :dtPedido, :vlTotal, :dsDescricao, :stOrcamento)";
            return $this->executar($sql, $dados);
        }
        return false;
    }

    public function atualizar(int $id): bool
    {
        $dados = [
            'id' => $id,
            'vlTotal' => $this->vlTotal,
            'stOrcamento' => $this->stOrcamento
        ];
        $sql = "UPDATE {$this->_table} SET vlTotal = :vlTotal, stOrcamento = :stOrcamento WHERE id = :id";
        return $this->executar($sql, $dados);
    }
}

?>