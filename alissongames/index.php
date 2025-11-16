<?php

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameStore</title>
    <link rel="stylesheet" href="view/style/usuario.css">
</head>

<body>

    <!-- HEADER -->
    <header class="header">
        <div class="logo">GameStore</div>

        <input type="text" class="search" placeholder="Buscar produtos...">

        <nav class="menu">
            <a href="#">Jogos</a>
            <a href="#">Consoles</a>
            <a href="#">Acessórios</a>
            <a href="#">Promoções</a>
        </nav>

        <div class="icons">
            <span class="icon">🛒</span>
            <span class="icon">👤</span>
        </div>
    </header>

    <!-- HERO / BANNER -->
    <section class="hero">
        <div class="hero-content">
            <h1>Os melhores jogos estão aqui!</h1>
            <p>Ofertas especiais todos os dias. Aproveite agora!</p>
            <button class="btn-hero">Comprar agora</button>
        </div>
    </section>



    <!-- DESTAQUES -->
    <h2 class="title">Destaques</h2>
    <div class="container-produtos">
        <?php
        require_once 'exibe-detalhes.php';
        $produtos = exibiProdutosDisponiveis($con);
        foreach ($produtos as $produto) {
            $preco = $produto['preco'];
            echo "<div class='card-produto'>";
            echo "<h3 class='titulo-produto'>" . $produto['nome'] . "</h3>";
            echo "<p class='preco-produto'>R$ " . number_format($preco, 2, ',', '.') . "</p>";

            echo "<form action='adicionar-carrinho.php' method='post'>";
            echo "<input type='hidden' name='id' value='" . $produto['id'] . "'>";
            echo "<button class='btn-add' type='submit'>Adicionar ao carrinho</button>";
            echo "</form>";
            echo "</div>";
        };
        

        ?>

    </div>

    <!-- CATEGORIAS -->
    <h2 class="title">Categorias</h2>
    <div class="categorias">
        <div class="cat-card">PS5</div>
        <div class="cat-card">Xbox</div>
        <div class="cat-card">PC</div>
        <div class="cat-card">Nintendo Switch</div>
        <div class="cat-card">Acessórios</div>
    </div>

    <!-- FOOTER -->
    <footer class="footer">
        © 2025 GameStore • Todos os direitos reservados
    </footer>
    <?php 
    if (isset($_GET['erro']) and $_GET['erro'] == 1) {
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
    if (isset($_GET['erro']) and $_GET['erro'] == 2) {
        echo "
    <script>
        Swal.fire({
            title: 'Erro',
            text: 'Produto Indisponivel',
            icon: 'error',
            confirmButtonText: 'Ok'
        });
    </script>";
    }
    ?>

</body>

</html>