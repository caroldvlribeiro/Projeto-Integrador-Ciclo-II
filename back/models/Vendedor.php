<?php
require_once 'Pessoa.php';
require_once '../interfaces/IAutenticavel.php';

/**
 * Model Vendedor
 * Gerencia os dados da tabela 'vendedor' e lida com login e comissões.
 */
class Vendedor extends Pessoa implements IAutenticavel
{
    protected $vl_comissao; // Porcentagem de comissão

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo, 'vendedor');
    }

    public function setComissao($valor)
    {
        $this->vl_comissao = $valor;
    }
    public function getComissao()
    {
        return $this->vl_comissao;
    }

    public function getPerfil(): string
    {
        return "Vendedor: {$this->nome} | Comissão: {$this->vl_comissao}%";
    }

    /**
     * Calcula o valor da comissão sobre um montante de venda.
     */
    public function calcularComissao($vl)
    {
        return $vl * ($this->vl_comissao / 100);
    }

    /**
     * Lista todas as vendas realizadas por este vendedor.
     */
    public function listarVendas()
    {
        $sql = "SELECT * FROM venda WHERE id_vendedor = (SELECT id_vendedor FROM {$this->_table} WHERE nm_vendedor = :nome)";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute(['nome' => $this->nome]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Salva um novo vendedor
    public function salvar(): bool
    {
        $dados = [
            'nm_vendedor' => $this->nome,
            'cd_senha' => $this->senha,
            'vl_comissao' => $this->vl_comissao
        ];

        if ($this->validar($dados)) {
            $sql = "INSERT INTO {$this->_table} (nm_vendedor, cd_senha, vl_comissao) 
                    VALUES (:nm_vendedor, :cd_senha, :vl_comissao)";
            return $this->executar($sql, $dados);
        }
        return false;
    }

    // Atualiza dados do vendedor
    public function atualizar(int $id): bool
    {
        $dados = [
            'id' => $id,
            'nm_vendedor' => $this->nome,
            'vl_comissao' => $this->vl_comissao
        ];

        if ($this->validar($dados)) {
            $sql = "UPDATE {$this->_table} SET nm_vendedor = :nm_vendedor, vl_comissao = :vl_comissao";
            if ($this->senha) {
                $sql .= ", cd_senha = :cd_senha";
                $dados['cd_senha'] = $this->senha;
            }
            $sql .= " WHERE id_vendedor = :id";
            return $this->executar($sql, $dados);
        }
        return false;
    }

    /**
     * Autenticação do vendedor.
     */
    public function autenticar(string $usuario, string $senha): bool
    {
        $sql = "SELECT * FROM {$this->_table} WHERE nm_vendedor = :nome";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute(['nome' => $usuario]);
        $vendedor = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($vendedor && password_verify($senha, $vendedor['cd_senha'])) {
            if (session_status() === PHP_SESSION_NONE)
                session_start();
            $_SESSION['vendedor'] = $vendedor;
            return true;
        }
        return false;
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
        }
    }

    public function temPermissao(string $acao): bool
    {
        return true; // Vendedores possuem permissões operacionais padrão
    }
}

?>