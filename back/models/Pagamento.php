<?php
require_once 'RegistroFinanceiro.php';

/**
 * Model Pagamento
 * Gerencia as entradas e saídas financeiras (tabela 'pagamento').
 */
class Pagamento extends RegistroFinanceiro
{

    protected $id_pagamento;
    protected $dt_pagamento_entrada;
    protected $dt_pagamento_saida;
    protected $vl_pagamento_entrada;
    protected $vl_pagamento_saida;

    public function __construct(PDO $PDO)
    {
        parent::__construct($PDO, 'pagamento');
    }

    /**
     * Calcula o valor total movimentado neste registro (Entrada + Saída).
     */
    public function calcularValor(): float
    {
        return (float) ($this->vl_pagamento_entrada + $this->vl_pagamento_saida);
    }

    // Setters para facilitar a gravação de dados
    public function setOrcamento($id)
    {
        $this->idOrcamento = $id;
    }
    public function setEntrada($valor, $data)
    {
        $this->vl_pagamento_entrada = $valor;
        $this->dt_pagamento_entrada = $data;
    }
    public function setSaida($valor, $data)
    {
        $this->vl_pagamento_saida = $valor;
        $this->dt_pagamento_saida = $data;
    }
    // Correção — adicionar os setters que o controller espera em Pagamento.php:
    public function setCdOrcamento($id) { $this->idOrcamento = $id; }
    public function setVlEntrada($valor) { $this->vl_pagamento_entrada = $valor; }
    public function setVlSaida($valor)   { $this->vl_pagamento_saida  = $valor; }
    public function setDtPagamentoEntrada($data) { $this->dt_pagamento_entrada = $data; }
    public function setDtPagamentoSaida($data)   { $this->dt_pagamento_saida  = $data; }

    // Registra um novo pagamento
    public function salvar(): bool
    {
        $dados = [
            'id_orcamento' => $this->idOrcamento,
            'dt_pagamento_entrada' => $this->dt_pagamento_entrada,
            'dt_pagamento_saida' => $this->dt_pagamento_saida,
            'vl_pagamento_entrada' => $this->vl_pagamento_entrada,
            'vl_pagamento_saida' => $this->vl_pagamento_saida
        ];

        if ($this->validar($dados)) {
            $sql = "INSERT INTO {$this->_table} 
                    (id_orcamento, dt_pagamento_entrada, dt_pagamento_saida, vl_pagamento_entrada, vl_pagamento_saida) 
                    VALUES (:id_orcamento, :dt_pagamento_entrada, :dt_pagamento_saida, :vl_pagamento_entrada, :vl_pagamento_saida)";
            return $this->executar($sql, $dados);
        }
        return false;
    }

    // Atualiza dados de um pagamento (ex: registrar a data de saída)
    public function atualizar(int $id): bool
    {
        $dados = [
            'id' => $id,
            'dt_pagamento_saida' => $this->dt_pagamento_saida,
            'vl_pagamento_saida' => $this->vl_pagamento_saida
        ];
        $sql = "UPDATE {$this->_table} SET 
                dt_pagamento_saida = :dt_pagamento_saida, 
                vl_pagamento_saida = :vl_pagamento_saida 
                WHERE id_pagamento = :id";
        return $this->executar($sql, $dados);
    }

    public function deletar($id): bool
{
    $sql = "DELETE FROM {$this->_table}
            WHERE id_pagamento = :id";

    $stmt = $this->_PDO->prepare($sql);

    return $stmt->execute([
        'id' => $id
    ]);
}
    
}

?>