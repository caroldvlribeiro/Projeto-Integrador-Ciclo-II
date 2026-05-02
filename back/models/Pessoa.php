<?php
require_once 'Model.php';
abstract class Pessoa extends Model
{
    protected $nome;
    protected $telefone;
    protected $senha;

    public function __construct(PDO $PDO, $table)
    {
        parent::__construct($PDO, $table);
    }
    public function getNome()
    {
        return $this->nome;
    }
    public function setNome($nome)
    {
        $this->nome = $nome;
    }
    public function getTelefone()
    {
        return $this->telefone;
    }
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }
    public function getSenha()
    {
        return $this->senha;
    }
    public function setSenha($senha)
    {
        $this->senha = $this->hashSenha($senha);
    }

    // Função faltante: hashSenha conforme diagrama
    protected function hashSenha($senha)
    {
        return password_hash($senha, PASSWORD_DEFAULT);
    }

    // Função faltante: getPerfil conforme diagrama
    abstract public function getPerfil(): string;

    // Métodos abstratos do Model que as classes filhas (Cliente, Vendedor) vão implementar
    abstract public function salvar(): bool;
    abstract public function atualizar(int $id): bool;
}

?>