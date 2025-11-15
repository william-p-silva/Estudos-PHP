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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header>
    <h1>Painel do Administrador</h1>
    <form action="../processa-logout.php" method="POST" id="navbar">
            <a href="admin.php">dashboard</a>
            <a href="cadastro-produto.php">Cadastrar Produto</a>
            <a href="produtos.php">Produtos</a>
            <a href="usuarios-detalhes.php">Usuarios</a>
            <a href="cadastro-admin.php">Cadastro Admin</a>
            <button class="sair" type="submit">Sair
        </form>
    </header>
    <main>
        <div>
            <h2>Cadastrar Administrador</h2>
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
    </main>
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
        if(isset($_GET['erro']) and $_GET['erro'] == 2){
            echo "
    <script>
        Swal.fire({
            title: 'Erro',
            text: 'Email já Cadastrado',
            icon: 'error',
            confirmButtonText: 'Ok'
        });
    </script>";
        }
        if(isset($_GET['erro']) and $_GET['erro'] == 3){
            echo "
    <script>
        Swal.fire({
            title: 'Erro',
            text: 'Erro desconhecido Tente novamente',
            icon: 'error',
            confirmButtonText: 'Ok'
        });
    </script>";
        }
    ?>
    
</body>
</html>