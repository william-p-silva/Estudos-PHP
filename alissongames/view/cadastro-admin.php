<?php 
session_start();
require_once '../verifica_secao.php';
verificar_acesso('admin');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro ADMIN</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <div>
        <h1>Cadastrar Administrador</h1>
        <form action="../processa-cadastro-adm.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
            <br><br>
            <label for="txtemail">Email:</label>
            <input type="email" id="email1" name="txtEmail" required>
            <br><br>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
            <br><br>
            <button type="submit">Cadastrar</button>
        </form>
    </div>
    <?php 
        if(isset($_GET['erro']) and $_GET['erro'] == 1){
            echo "<script>window.alert('Dados Invalidos')</script>";
        }
        if(isset($_GET['erro']) and $_GET['erro'] == 2){
            echo "<script>window.alert('Email já Cadastrado')</script>";
        }
        if(isset($_GET['erro']) and $_GET['erro'] == 3){
            echo "<script>window.alert('Erro de insert no banco')</script>";
        }
    ?>
    
</body>
</html>