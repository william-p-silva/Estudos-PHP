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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        #justo {
            text-align: justify;
        }
    </style>
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
    <script>
        function confirmarExclusao(id, nome) {
            Swal.fire({
                title: "Excluir produto?",
                text: `Tem certeza que deseja excluir o produto de ID: ${id} e Nome: ${nome}? Esta ação não pode ser desfeita.`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sim, excluir",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "excluir.php?id=" + id;
                }
            });
        }
    </script>
</body>

</html>
<?php
if (isset($_GET['erro']) && $_GET['erro'] == 1) {
    echo "<script>window.alert('Erro ao buscar produtos.')</script>";
}
if (isset($_GET['sucesso']) and $_GET['sucesso'] == 1) {
    echo "<script>window.alert('Alteração Realizada com sucesso')</script>";
}
?>