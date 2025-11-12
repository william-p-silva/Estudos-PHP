<?php 
session_start();
require_once 'verifia_secao.php';
verificar_acesso('admin');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Olá ADM</h1>
    <form action="admin.php" method="get">
        <input type="submit" value="Cadastrar Novo Admin" formaction="cadastro-admin.php">
    </form>
</body>
</html>