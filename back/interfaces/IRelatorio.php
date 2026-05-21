<?php
interface IRelatorio
{
    public function gerarRelatorio() : array;
    public function filtrarPorPeriodo(string $dataInicio, string $dataFim) : array;
    public function exportar(string $formato) : string;
}

?>