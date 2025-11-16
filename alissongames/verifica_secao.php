<?php

function verificar_acesso($perfisPermitidos = null, $paginaLogin = 'tela-login.php')
{
    if (!isset($_SESSION['id'])) {
        session_unset();
        session_destroy();
        header("location: $paginaLogin?erro=login-invalido");
        exit;
    }

    if ($perfisPermitidos !== null) {

        if (!in_array($_SESSION['perfil'], (array)$perfisPermitidos)) {
            header("location: $paginaLogin?erro=acesso-negado");
            exit;
        }
    }
}

