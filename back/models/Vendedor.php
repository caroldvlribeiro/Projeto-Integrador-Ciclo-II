<?php 
require_once 'Pessoa.php';

class Vendedor extends Pessoa implements IAutenticavel {

    private $senha;
    private $vlComissao;

    public function __construct(PDO $pdo) {
        parent::__construct($pdo, 'vendedores');
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function getVlComissao() {
        return $this->vlComissao;
    }

    public function setVlComissao($vlComissao) {
        $this->vlComissao = $vlComissao;
    }

    // CREATE
    public function salvar() {
        if (!$this->validar([
            $this->getNome(), 
            $this->getTelefone(), 
            $this->senha, 
            $this->vlComissao
        ])) {
            return false;
        }

        $sql = "INSERT INTO {$this->_table} 
                (nome, telefone, senha, vl_comissao) 
                VALUES (:nome, :telefone, :senha, :vl_comissao)";

        return $this->executar($sql, [
            'nome' => $this->getNome(),
            'telefone' => $this->getTelefone(),
            'senha' => password_hash($this->senha, PASSWORD_DEFAULT),
            'vl_comissao' => $this->vlComissao
        ]);
    }

    // UPDATE
    public function atualizar() {
        if (!$this->getId()) {
            throw new Exception("ID do vendedor não definido");
        }

        if (!$this->validar([
            $this->getNome(), 
            $this->getTelefone(), 
            $this->vlComissao
        ])) {
            return false;
        }

        $dados = [
            'id' => $this->getId(),
            'nome' => $this->getNome(),
            'telefone' => $this->getTelefone(),
            'vl_comissao' => $this->vlComissao
        ];

        $sql = "UPDATE {$this->_table} 
                SET nome = :nome, telefone = :telefone, vl_comissao = :vl_comissao";

        if ($this->senha) {
            $sql .= ", senha = :senha";
            $dados['senha'] = password_hash($this->senha, PASSWORD_DEFAULT);
        }

        $sql .= " WHERE id = :id";

        return $this->executar($sql, $dados);
    }

    // LOGIN
    public function autenticar($telefone, $senha) {
        $sql = "SELECT * FROM {$this->_table} WHERE telefone = :telefone";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute(['telefone' => $telefone]);

        $vendedor = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($vendedor && password_verify($senha, $vendedor['senha'])) {
            unset($vendedor['senha']);
            return $vendedor;
        }
        return false;
    }

    public function logout(){
        session_unset();
        session_destroy();
    }

    

    public function calcularComissao($vl){
        return $vl * ($this->vlComissao / 100);
    }

    public function listarVendas() {
        $sql = "SELECT * FROM vendas WHERE vendedor_id = :vendedor_id";
        $stmt = $this->_PDO->prepare($sql);
        $stmt->execute(['vendedor_id' => $this->getId()]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function temPermissao($acao){

    $permissoes = [
        'visualizar_vendas',
        'cadastrar_venda',
        'calcular_comissao',
        'ver_cliente'
    ];

    return in_array($acao, $permissoes);
}
}