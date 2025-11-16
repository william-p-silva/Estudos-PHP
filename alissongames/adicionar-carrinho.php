<?php 
session_start();
require_once 'conexao.php';
require_once 'verifica_secao.php';
verificar_acesso(['cliente', 'admin'], 'view/tela-login.php');


if (!isset($_POST['id']) or !is_numeric($_POST['id'])){
    header('Location: index.php?erro=1');
    exit();
}else{
    $idProduto = $_POST['id'];
    $idUsuario = $_SESSION['id'];
    try{
        $sqlCheck = "SELECT COUNT(*) FROM produtos WHERE id = :id AND ativo = 1 AND estoque > 0";
        $stmtCheck = $con->prepare($sqlCheck);
        $stmtCheck->execute(['id' => $idProduto]);
        $produtoValido = $stmtCheck->fetchColumn();

        if ($produtoValido < 1){
            header('Location: index.php?erro=2');
            exit();
        }
        
    }
}

?>