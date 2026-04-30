<?php

interface IAutenticavel
{
    public function autenticar($usuario, $senha);
    public function logout();
    public function temPermissao($acao);
}

?>