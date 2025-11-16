<?php
session_start();

if (empty($_POST['txtEmail']) or empty($_POST['senha'])) {
    header('Location: view/tela-login.php?erro=1');
    exit;
} else {
    // Obtém os dados enviados pelo formulário
    $email = $_POST['txtEmail'];
    $senha_digitada = $_POST['senha'];

    try {
        require_once 'conexao.php';

        $sql = "SELECT id, nome, email, senha, perfil FROM usuarios WHERE email = :email";

        $stmt = $con->prepare($sql);
        $stmt->execute(['email' => $email]);
        if ($stmt->rowCount() == 1) {
            //verifica se o email está correto
            $usuario = $stmt->fetch();
            if (password_verify($senha_digitada, $usuario['senha'])) {
                //senha correta

                $_SESSION['id'] = $usuario['id'];
                $_SESSION['nome'] = $usuario['nome'];
                $_SESSION['email'] = $usuario['email'];
                $_SESSION['perfil'] = $usuario['perfil'];
                if ($usuario['perfil'] == 'admin') {
                    header('Location: view/admin.php');
                } else {
                    header('Location: index.php');
                }
                exit;
            } else {
                //senha incorreta
                header('Location: view/tela-login.php?erro=login-invalido');
                exit;
            }
        } else {
            header('Location: view/tela-login.php?erro=login-invalido');
            exit;
        }
    } catch (PDOException $e) {
        // Em produção, registre o erro em um log ao invés de mostrar ao usuário
        // echo "Erro ao consultar: " . $e->getMessage();
        header('Location: view/tela-login.php?erro=login-invalido');
        exit;
    }
}


