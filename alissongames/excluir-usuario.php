<?php
session_start();
require_once 'conexao.php';
require_once 'verifica_secao.php';
verificar_acesso('admin', 'view/tela-login.php');

if (empty($_GET['id']) or !is_numeric($_GET['id'])) {
    header('Location: view/usuarios-detalhes.php?erro=1');
    exit();
} else {
    try {
        $id = $_GET['id'];
        $sql = "SELECT COUNT(*) FROM usuarios WHERE id = :id AND perfil = 'cliente'";
        $stmt = $con->prepare($sql);
        $stmt->execute([':id' => $id]);
        $count = $stmt->fetchColumn();
        if ($count != 1) {
            header('Location: view/usuarios-detalhes.php?erro=2');
            exit();
        }

        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $con->prepare($sql);
        $stmt->execute([':id' => $id]);
        header('Location: view/usuarios-detalhes.php?sucesso=1');
        exit();
        
    } catch (PDOException $e) {
        header('Location: view/usuarios-detalhes.php?erro=1');
        exit();
    }
}
