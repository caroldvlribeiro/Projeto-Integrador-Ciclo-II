<?php
require_once 'ItemEstoque.php';

/**
 * Model Pedra
 * Gerencia os tipos de mármores e granitos (tabela 'pedra').
 */
class Pedra extends ItemEstoque
{
    public function __construct(PDO $PDO)
    {
        parent::__construct($PDO, 'pedra');
    }

    /**
     * Calcula o valor de venda sugerido (ex: 50% de lucro).
     */
    public function calcularVlVenda()
    {
        return $this->vlCompra * 1.5;
    }

    // Salva uma nova pedra no catálogo
    public function salvar(): bool
    {
        $dados = [
            'nm_pedra' => $this->nome,
            'ds_pedra' => $this->descricao,
            'vl_compra_pedra' => $this->vlCompra,
            'vl_venda_pedra' => $this->vlVenda ?? $this->calcularVlVenda()
        ];

        if ($this->validar($dados)) {
            $sql = "INSERT INTO {$this->_table} (nm_pedra, ds_pedra, vl_compra_pedra, vl_venda_pedra) 
                    VALUES (:nm_pedra, :ds_pedra, :vl_compra_pedra, :vl_venda_pedra)";
            return $this->executar($sql, $dados);
        }
        return false;
    }

    // Atualiza dados da pedra
    public function atualizar(int $id): bool
    {
        $dados = [
            'id' => $id,
            'nm_pedra' => $this->nome,
            'ds_pedra' => $this->descricao,
            'vl_compra_pedra' => $this->vlCompra,
            'vl_venda_pedra' => $this->vlVenda
        ];

        if ($this->validar($dados)) {
            $sql = "UPDATE {$this->_table} SET 
                    nm_pedra = :nm_pedra, 
                    ds_pedra = :ds_pedra, 
                    vl_compra_pedra = :vl_compra_pedra, 
                    vl_venda_pedra = :vl_venda_pedra 
                    WHERE id_pedra = :id";
            return $this->executar($sql, $dados);
        }
        return false;
    }
}

?>