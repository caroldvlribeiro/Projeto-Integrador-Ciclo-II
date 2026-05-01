<?php

interface INotificavel
{
    public function notificar(string $mensagem): void;
    public function enviarAlerta(string $tipo): bool;
}

?>