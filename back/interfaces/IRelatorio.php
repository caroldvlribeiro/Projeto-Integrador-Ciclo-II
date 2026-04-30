<?php
interface IRelatorio
{
    public function gerarRelatorio();
    public function filtrarPorPeriodo($dataInicio, $dataFim);
    public function exportar($formato);
}

?>