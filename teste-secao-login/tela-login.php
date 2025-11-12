<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<form action="processa-login.php" method="POST">

        <label for="txtemail">Email:</label>
        <input type="email" id="email1" name="txtEmail" required>
        <br><br>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        <br><br>
        <button type="submit">Cadastrar</button>
    </form>
    <?php 
    if(isset($_GET['erro']) and $_GET['erro'] == 1){
        echo "<script>window.alert('Dados Invalidos')</script>";
    }
    if(isset($_GET['erro']) and $_GET['erro'] == 'login-invalido'){
        echo "<script>window.alert('Email ou senha invalido')</script>";
    }
    if(isset($_GET['erro']) and $_GET['erro'] == 'acesso-negado'){
        echo "<script>window.alert('acesso negado')</script>";
    }
    ?>
</body>
</html>