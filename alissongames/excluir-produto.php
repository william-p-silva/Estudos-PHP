<?php 
session_start();
require_once 'conexao.php';
require_once 'verifica_secao.php';
verificar_acesso('admin');
if (empty($_GET['id']) or !is_numeric($_GET['id'])) {
    header('Location: view/produtos.php?erro=1');
    exit();
} else {
    try {
        $id = $_GET['id'];
        $sql = "DELETE FROM produtos WHERE id = :id";
        $stmt = $con->prepare($sql);
        $stmt->execute([':id' => $id]);
        header('Location: view/produtos.php?sucesso=2');
        exit();
    }catch (PDOException $e){
        header('Location: view/produtos.php?erro=1');
        exit();
    }
}
?>