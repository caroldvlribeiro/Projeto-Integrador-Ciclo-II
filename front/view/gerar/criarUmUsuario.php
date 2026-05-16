<?php
require_once __DIR__ . '/../../../back/config/database.php';
require_once __DIR__ . '/../../../back/models/Usuario.php';

$u = new Usuario($pdo);
$u->setEmail('admin@marmoraria.com'); // setEmail pode incluir validação de formato de email
$u->setSenha('admin123');             // setSenha já faz o hash automaticamente
$u->setTipo('Administrador');
$u->salvar();

echo "Usuário criado!";