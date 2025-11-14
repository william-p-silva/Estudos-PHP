<?php
session_start();
require_once '../conexao.php';
require_once '../verifica_secao.php';
verificar_acesso('admin');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - Administração</title>
    <link rel="stylesheet" href="style/produtos.css">
</head>

<body>

    <header>
        <h1>Painel do Administrador</h1>

        <form action="../processa-logout.php" method="POST" id="navbar">
            <a href="admin.php">dashboard</a>
            <a href="cadastro-produto.php">Cadastrar Produto</a>
            <a href="produtos.php">Produtos</a>

            <button class="sair" type="submit">Sair
        </form>
    </header>


    <main>
        <h2>Produtos Cadastrados</h2>

        <div class="produtos">
            <!-- Card 1 -->
            <?php 
            require_once '../conexao.php';         
            require_once '../exibe-produtos.php';
                exibeProduto($con);
                    
            ?>

        </div>
    </main>


    <footer>
        &copy; 2025 - Painel Administrativo
    </footer>

</body>

</html>