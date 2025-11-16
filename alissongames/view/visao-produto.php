<?php
session_start();
require_once '../verifica_secao.php';
require_once '../exibe-detalhes.php';
verificar_acesso(['cliente', 'admin'], 'tela-login.php');
if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {
    header('Location: ../index.php?erro=1');
    exit();
} else {
    $id = $_GET['id'];
}
$produto = exibirDetalhesProdutos($con, $id);
$preco = $produto['preco'];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produto | Loja Gamer</title>
    <link rel="stylesheet" href="style/produto-visao.css">
    <link rel="stylesheet" href="style/usuario.css">
</head>

<body>
<?php 
    require_once '../exibir-front.php';
    exibirNavBar();
    ?>


    <div class="container">
        <div class="produto-container">

            <!-- IMAGEM -->
            <div class="imagem-produto">
                <div class="placeholder-img">
                    Imagem do Produto
                </div>
            </div>

            <!-- INFORMAÇÕES -->
            <div class="info-produto">
                <h1><?= $produto['nome'] ?></h1>

                <p class="preco">R$ <?= number_format($preco, 2, ',', '.') ?></p>

                <p class="descricao">
                    <?= $produto['descricao'] ?>
                </p>

                <p class="estoque"><strong>Em estoque: </strong><?= $produto['estoque'] ?></p>

                <!-- QUANTIDADE -->
                <form action="../adicionar-carrinho.php" method="post">
                    <label for="qtd">Quantidade:</label>
                    <select id="qtdProduto" name="qtd">
                        <?php
                        for ($i = 1; $i <= $produto['estoque']; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>

                    </select>

                    <!-- BOTÃO -->

                    <input type="number" name="idProduto" id="id" value="<?= $produto['id'] ?>" hidden>
                    <button class="btn-carrinho" type="submit">
                        Adicionar ao Carrinho
                    </button>
                </form>
            </div>
        </div>

        <!-- DETALHES TÉCNICOS -->
        <div class="detalhes">
            <h2>Detalhes Técnicos</h2>

            <?php
            for ($i = 1; $i <= 4; $i++) {
                echo $produto['descricao'] . "<br><br>";
            }
            ?>
        </div>

    </div>
    <?php 
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
    <footer class="footer">
        © 2025 GameStore • Todos os direitos reservados
    </footer>
</body>

</html>