<?php

interface IAutenticavel
{
    public function autenticar($user, $senha);
    public function logout();
    public function temPermissao($acao);
}

?>