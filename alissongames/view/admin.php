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
    <title>Painel Administrativo - Loja de Jogos</title>
    <link rel="stylesheet" href="style/styleAdmin.css">

</head>

<body>
    <header>
        <h1>Painel do Administrador</h1>
        <form action="../processa-logout.php" method="POST" id="navbar">
            <a href="cadastro-produto.php">Cadastrar Produto</a>
            <a href="#">Produtos</a>
            <button class="sair" type="submit">Sair
        </form>
    </header>

    <main>
        <h2>Visão Geral</h2>

        <!-- Cards Resumo -->
        <div class="cards">
            <div class="card" style="border-top-color: #4f46e5;">
                <p>Usuários</p>
                <h3>
                    <?php
                    require_once '../exibe-detalhes.php';
                    echo contarUsuarios($con);
                    ?>
                </h3>
            </div>

            <a href="cadastro-produto.php">
                <div class="card" style="border-top-color: #16a34a;">
                    <p>Produtos</p>
                    <h3>
                        <?php
                        require_once '../exibe-detalhes.php';
                        echo contarProdutos($con);
                        ?>
                    </h3>
                </div>
            </a>

            <div class="card" style="border-top-color: #d97706;">
                <p>Pedidos Pendentes</p>
                <h3>
                    <?php
                    require_once '../exibe-detalhes.php';
                    echo contarPedidos($con);
                    ?>
                </h3>
            </div>

            <div class="card" style="border-top-color: #2563eb;">
                <p>Faturamento Total</p>
                <h3>R$ 14.520,00</h3>
            </div>
        </div>

        <!-- Últimos Pedidos -->
        <section>
            <h3>Últimos Pedidos</h3>
            <table>
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Cliente</th>
                        <th>Data</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>45</td>
                        <td>João Silva</td>
                        <td>13/11/2025</td>
                        <td>R$ 259,90</td>
                        <td class="status pendente">Pendente</td>
                    </tr>
                    <tr>
                        <td>44</td>
                        <td>Maria Souza</td>
                        <td>12/11/2025</td>
                        <td>R$ 139,00</td>
                        <td class="status pago">Pago</td>
                    </tr>
                    <tr>
                        <td>43</td>
                        <td>Pedro Costa</td>
                        <td>12/11/2025</td>
                        <td>R$ 349,00</td>
                        <td class="status enviado">Enviado</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        © 2025 Loja de Jogos. Todos os direitos reservados.
    </footer>
</body>

</html>