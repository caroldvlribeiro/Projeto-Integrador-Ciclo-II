<?php
require_once 'Pessoa.php';
require_once '../interfaces/IAutenticavel.php';

class Vendedor extends Pessoa implements IAutenticavel
{

    private $idVendedor;
    private $vlComissao;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo, 'vendedores');
    }

    // GETTERS E SETTERS
    public function setIdVendedor($idVendedor)
    {
        $this->idVendedor = $idVendedor;
    }

    public function getIdVendedor()
    {
        return $this->idVendedor;
    }

    public function getVlComissao()
    {
        return $this->vlComissao;
    }

    public function setVlComissao($vlComissao)
    {
        $this->vlComissao = $vlComissao;
    }

    // MÉTODOS DO DIAGRAMA
    public function getPerfil(): string
    {
        return "Vendedor: {$this->nome} | Comissão: {$this->vlComissao}%";
    }

    public function calcularComissao($vl)
    {
        return $vl * ($this->vlComissao / 100);
    }

    public function listarVendas()
    {
        $sql = "SELECT * FROM vendas WHERE vendedor_id = :vendedor_id";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute(['vendedor_id' => $this->idVendedor]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // CREATE
    public function salvar(): bool
    {
        $dados = [
            'nome' => $this->nome,
            'telefone' => $this->telefone,
            'senha' => $this->senha,
            'vl_comissao' => $this->vlComissao
        ];

        if ($this->validar($dados)) {
            $sql = "INSERT INTO {$this->_table} 
                    (nome, telefone, senha, vl_comissao) 
                    VALUES (:nome, :telefone, :senha, :vl_comissao)";
            return $this->executar($sql, $dados);
        }
        return false;
    }

    // UPDATE
    public function atualizar(int $id): bool
    {
        $dados = [
            'id' => $id,
            'nome' => $this->nome,
            'telefone' => $this->telefone,
            'vl_comissao' => $this->vlComissao
        ];

        if ($this->validar($dados)) {
            $sql = "UPDATE {$this->_table} 
                    SET nome = :nome, telefone = :telefone, vl_comissao = :vl_comissao";

            if ($this->senha) {
                $sql .= ", senha = :senha";
                $dados['senha'] = $this->senha;
            }

            $sql .= " WHERE id = :id";

            return $this->executar($sql, $dados);
        }
        return false;
    }

    // LOGIN (IAutenticavel)
    public function autenticar(string $usuario, string $senha): bool
    {
        $sql = "SELECT * FROM {$this->_table} WHERE nome = :nome";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute(['nome' => $usuario]);

        $vendedor = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($vendedor && password_verify($senha, $vendedor['senha'])) {
            unset($vendedor['senha']);

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['vendedor'] = $vendedor;
            return true;
        }
        return false;
    }

    // LOGOUT (IAutenticavel)
    public function logout(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
        }
    }

    // PERMISSÃO (IAutenticavel)
    public function temPermissao(string $acao): bool
    {
        $permissoes = [
            'visualizar_vendas',
            'cadastrar_venda',
            'calcular_comissao',
            'ver_cliente'
        ];

        return in_array($acao, $permissoes);
    }
}
?>