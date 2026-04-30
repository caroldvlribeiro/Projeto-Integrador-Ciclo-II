<?php

interface INotificavel
{
    public function notificar($mensagem);
    public function enviarAlerta($tipo);
}

?>