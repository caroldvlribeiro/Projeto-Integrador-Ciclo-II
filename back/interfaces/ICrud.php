<?php
interface ICrud
{
    public function salvar();
    public function atualizar();
    public function deletar($id);
    public function buscarPorId($id);
    public function listarTodos();
}
?>