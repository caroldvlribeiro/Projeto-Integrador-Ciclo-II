<?php
require_once 'Model.php';

/**
 * Classe Abstrata Pessoa
 * Base para todos os seres humanos do sistema (Clientes, Usuários, Vendedores).
 */
abstract class Pessoa extends Model
{
    protected $nome;
    protected $telefone;
    protected $senha;

    public function __construct(PDO $PDO, $table)
    {
        parent::__construct($PDO, $table);
    }

    // Getters e Setters básicos
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

    // Define a senha já aplicando a criptografia hash
    public function setSenha($senha)
    {
        $this->senha = $this->hashSenha($senha);
    }

    /**
     * Gera o hash da senha para armazenamento seguro.
     * Verifica se já é um hash para evitar criptografia dupla.
     */
    protected function hashSenha($senha)
    {
        if (strlen($senha) == 60 && strpos($senha, '$2y$') === 0) {
            return $senha;
        }
        return password_hash($senha, PASSWORD_DEFAULT);
    }

    // Método para retornar uma string de identificação do perfil
    abstract public function getPerfil(): string;
}

?>