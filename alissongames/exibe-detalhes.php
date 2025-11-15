<?php
    require_once '../conexao.php';


function contarUsuarios($con)
{

    $sql = "SELECT COUNT(*) AS total FROM usuarios";
    $stmt = $con->query($sql);
    $stmt = $stmt->fetchColumn();
    return $stmt;
}


function contarProdutos($con)
{
    $sql = "SELECT COUNT(*) AS total FROM produtos";
    $stmt = $con->query($sql);
    $stmt = $stmt->fetchColumn();
    return $stmt;
}

function contarPedidos($con){
    $sql = "SELECT COUNT(*) AS total FROM pedidos";
    $stmt = $con->query($sql);
    $stmt = $stmt->fetchColumn();
    return $stmt;
}

function vericarProduto($con)
{
    if (!isset($_GET['id'])) {
        header('Location: produtos.php?erro=1');
        exit();
    } else if (empty($_GET['id']) or !is_numeric($_GET['id'])) {
        header('Location: produtos.php?erro=1');
        exit();
    }else{
        $id = $_GET['id'];
        $sql = "SELECT id, nome, descricao, preco, estoque, ativo FROM produtos WHERE id = :id";
        $stmt = $con->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $produto = $stmt->fetch();
    }
}

function exibirUsuarios($con){
    try {
        $sql = "SELECT id, nome, email, perfil, data_cadastro FROM usuarios ORDER BY data_cadastro DESC";
        $stmt = $con->query($sql);
        $usuarios = $stmt->fetchAll();
        return $usuarios;

    }catch (PDOException $e){
        header('Location: view/usuarios-detalhes.php?erro=1');
        exit();
    }
}
