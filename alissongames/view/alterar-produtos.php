<?php
session_start();
require_once '../conexao.php';
require_once '../exibe-detalhes.php';
require_once '../verifica_secao.php';
verificar_acesso('admin');
$produto = vericarProduto($con);
$selected_sim = ($produto['ativo'] == 1) ? 'selected' : '';
$selected_nao = ($produto['ativo'] == 0) ? 'selected' : '';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="style/styleAdmin.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background-color: #4f46e5;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        header h1 {
            font-size: 1.5em;
            font-weight: bold;
        }

        header nav a {
            color: white;
            margin-left: 15px;
            text-decoration: none;
            transition: opacity 0.2s;
        }

        header nav a:hover {
            opacity: 0.8;
            text-decoration: underline;
        }

        main {
            flex: 1;
            padding: 30px;
            max-width: 800px;
            margin: auto;
            width: 100%;
        }

        h2 {
            font-size: 1.3em;
            margin-bottom: 20px;
        }

        #cadastro-produto-form {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1em;
            transition: border-color 0.2s;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: #4f46e5;
            outline: none;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .btn-group {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-salvar {
            background-color: #4f46e5;
            color: white;
        }

        .btn-salvar:hover {
            background-color: #4338ca;
        }

        .btn-cancelar {
            background-color: #e5e7eb;
            color: #333;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-cancelar:hover {
            background-color: #d1d5db;
        }

        footer {
            text-align: center;
            padding: 15px;
            font-size: 0.9em;
            color: #777;
            border-top: 1px solid #ddd;
            background-color: #fafafa;
        }

        @media (max-width: 600px) {
            header {
                flex-direction: column;
                align-items: flex-start;
            }

            header nav {
                margin-top: 10px;
            }
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
            <a href="usuarios-detalhes.php">Usuarios</a>
            <a href="cadastro-admin.php">Cadastro Admin</a>
            <button class="sair" type="submit">Sair
        </form>
    </header>

    <main>
        <h2>Editar Produto</h2>

        <form action="../editar-produto.php" method="POST" id="cadastro-produto-form">

            <div class="form-group">
                <label for="nome">ID do Produto</label>
                <input type="text" id="id" name="id" required value="<?= $produto['id'] ?>" readonly>
            </div>

            <div class="form-group">
                <label for="nome">Nome do Produto</label>
                <input type="text" id="nome" name="nome" required value="<?= $produto['nome'] ?>">
            </div>

            <div class="form-group">
                <label for="descricao">Descrição</label>
                <textarea id="descricao" name="descricao" required><?= $produto['descricao'] ?></textarea>
            </div>

            <div class="form-group">
                <label for="preco">Preço (R$)</label>
                <input type="number" id="preco" name="preco" step="0.01" min="0" value="<?= $produto['preco'] ?>" required>
            </div>

            <div class="form-group">
                <label for="estoque">Quantidade em Estoque</label>
                <input type="number" id="estoque" name="estoque" min="0" value="<?= $produto['estoque'] ?>" required>
            </div>
            <div class="form-group">
                <label for="ativo">Produto Ativo?</label>
                <select id="ativo" name="ativo" required>

                    <option value='1' <?= $selected_sim?>>Sim</option>
                    <option value='0' <?= $selected_nao?>>Não</option>";



                </select>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn-salvar">Salvar Produto</button>
                <a href="produtos.php"><div class="btn-cancelar">Voltar</div></a>
            </div>

        </form>
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

        ?>
    </main>

    <footer>
        © 2025 Loja de Jogos. Todos os direitos reservados.
    </footer>
</body>

</html>