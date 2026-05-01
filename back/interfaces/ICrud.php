<?php
interface ICrud
{
    public function salvar();
    public function atualizar($id);
    public function deletar($id);
    public function buscarPorId($id);
    public function listarTodos();
}

?>