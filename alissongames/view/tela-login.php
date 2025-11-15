<?php 
session_start();
require_once '../verifica_secao.php'
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<form action="../processa-login.php" method="POST">

        <label for="txtemail">Email:</label>
        <input type="email" id="email1" name="txtEmail" required>
        <br><br>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        <br><br>
        <button type="submit">Entrar</button>
        <p id="cad" >Ainda não tem um cadastro? <a href="cadastro-cliente.php">Clique aqui</a></p>
    </form>
    <?php 
     if(isset($_GET['erro']) and $_GET['erro'] == 1){
        echo "
    <script>
        Swal.fire({
            title: 'Erro',
            text: 'Dados Invalidos',
            icon: 'error',
            confirmButtonText: 'Ok'
        });
    </script>";
    }
    if(isset($_GET['erro']) and $_GET['erro'] == 'login-invalido'){
        echo "
        <script>
            Swal.fire({
                title: 'Erro',
                text: 'Email ou Senha invalido',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        </script>";
    }
    if(isset($_GET['erro']) and $_GET['erro'] == 'acesso-negado'){
        echo "
    <script>
        Swal.fire({
            title: 'Erro',
            text: 'Acesso Negado',
            icon: 'error',
            confirmButtonText: 'Ok'
        });
    </script>";
    }
    if (isset($_GET) and isset($_GET['msg']) == 'logout-sucesso') {
        echo "
    <script>
        Swal.fire({
            title: 'Sucesso',
            text: 'Você saiu da sua conta com sucesso!',
            icon: 'success',
            confirmButtonText: 'Ok'
        });
    </script>";
    }
    ?>
</body>
</html>