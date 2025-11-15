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
    <title>Usuarios</title>
    <link rel="stylesheet" href="style/styleAdmin.css">
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


        <!-- Últimos Pedidos -->
        <section>
            <h3>Últimos Pedidos</h3>
            <table>
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Perfil</th>
                        <th>Data de Cadastro</th>
                        <th>Alteração</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once '../exibe-detalhes.php';
                    $usuarios = exibirUsuarios($con);

                    foreach ($usuarios as $usuario) {
                        $perfilAdmin = $usuario['perfil'] == 'admin' ? 'status admin' : '';
                        $perfilCliente = $usuario['perfil'] == 'cliente' ? 'status cliente' : '';
                        echo "<tr>
                                <td class='status'>{$usuario['id']}</td>
                                <td>{$usuario['nome']}</td>
                                <td>{$usuario['email']}</td>
                                <td class='$perfilCliente $perfilAdmin' >{$usuario['perfil']}</td>
                                <td>{$usuario['data_cadastro']}</td>
                                ";
                        if ($usuario['perfil'] == 'cliente') {
                            echo "
<td class='btn-excluir' onclick='confirmarExclusao({$usuario['id']}, \"{$usuario['nome']}\", \"{$usuario['email']}\")'>
    <a class='excluir'>Excluir</a>
</td>
";
                        } else {
                            echo "<td class='btn-editar'></td></tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
    <script>
        function confirmarExclusao(id, nome, email) {
            Swal.fire({
                title: "Excluir Usuario?",
                text: `Tem certeza que deseja excluir o Usuario: ${nome} com Email: ${email}?
                Esta ação não pode ser desfeita.`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sim, excluir",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../excluir-usuario.php?id=" + id;
                }
            });
        }
    </script>
    <footer>
        © 2025 Loja de Jogos. Todos os direitos reservados.
    </footer>
    <?php
    if (isset($_GET['erro']) and $_GET['erro'] == 1) {
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
    if (isset($_GET['erro']) and $_GET['erro'] == 2) {
        echo "
<script>
    Swal.fire({
        title: 'Erro',
        text: 'Usuario não encontrado',
        icon: 'error',
        confirmButtonText: 'Ok'
    });
</script>";
    }
    if (isset($_GET['sucesso']) and $_GET['sucesso'] == 1) {
        echo "
<script>
    Swal.fire({
        title: 'Sucesso',
        text: 'Usuario excluido com Sucesso',
        icon: 'success',
        confirmButtonText: 'Ok'
    });
</script>";
    }
    ?>
</body>

</html>