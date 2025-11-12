<?php

function verificar_acesso($perfilRequerido = null, $paginaLogin = 'tela-login.php')
{
    if (!isset($_SESSION['id'])) {
        session_unset();
        session_destroy();
        header("location: $paginaLogin?erro=login-invalido");
        exit;
    }

    // VERIFICADOR: Se o ID não existe OU se o perfil NÃO é 'admin', bloqueia o acesso
    if ($perfilRequerido !== null) {
        // Verifica se o perfil logado NÃO É o perfil exigido
        if ($_SESSION['perfil'] !== $perfilRequerido) {
            // Se for cliente tentando acessar ADMIN, redireciona para a área dele
            if ($_SESSION['perfil'] === 'cliente') {
                header("location: us.php?erro=acesso-negado"); // Vai para a área do cliente
                exit;
            } else {
                if ($_SESSION['perfil'] == 'admin') {
                    // Se for admin tentando acessar área de cliente, redireciona para a área dele
                    header("location: admin.php?erro=sem-acesso"); // Vai para a área do admin
                    exit;
                } else {
                    // Destrói qualquer sessão incompleta ou incorreta
                    session_unset();
                    session_destroy();
                    // Redireciona para a tela de login
                    header("location: $paginaLogin?erro=acesso-negado"); // Vai para a área do cliente
                    exit;
                }
            }
        }
    }
}
