<?php
interface ICrud
{
    public function salvar(): bool;
    public function atualizar(int $id): bool;
    public function deletar(int $id): bool;
    public function buscarPorId(int $id): mixed;
    public function listarTodos(): array;
}
?>