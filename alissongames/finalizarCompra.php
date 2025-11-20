<?php 
session_start();
require_once 'conexao.php';
require_once 'verifica_secao.php';
verificar_acesso(['cliente'], 'view/tela-login.php');

