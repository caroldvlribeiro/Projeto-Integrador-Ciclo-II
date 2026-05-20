<?php

interface IAutenticavel
{
    public function autenticar(string $usuario, string $senha): bool;
    public function logout(): void;
    public function temPermissao(string $acao): bool;
}

?>