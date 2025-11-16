<?php
    require_once 'conexao.php';


function contarUsuarios($con)
{
    try{
    $sql = "SELECT COUNT(*) AS total FROM usuarios";
    $stmt = $con->query($sql);
    $stmt = $stmt->fetchColumn();
    return $stmt;
    }catch (PDOException $e){
        header('Location: admin.php?erro=1');
        exit();
    }
}


function contarProdutos($con)
{
    try{
    $sql = "SELECT COUNT(*) AS total FROM produtos";
    $stmt = $con->query($sql);
    $stmt = $stmt->fetchColumn();
    return $stmt;
    }catch (PDOException $e){
        header('Location: admin.php?erro=1');
        exit();
    }
}

function contarPedidos($con){
    try{
        
    $sql = "SELECT COUNT(*) AS total FROM pedidos";
    $stmt = $con->query($sql);
    $stmt = $stmt->fetchColumn();
    return $stmt;
    }catch (PDOException $e){
        header('Location: admin.php?erro=1');
        exit();
    }
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

function exibiProdutosDisponiveis($con){
    try {
        $sql = "SELECT id, nome, descricao, preco, estoque, ativo FROM produtos WHERE ativo = 1 AND estoque > 0 ORDER BY nome ASC";
        $stmt = $con->query($sql);
        $produtos = $stmt->fetchAll();
        return $produtos;

    }catch (PDOException $e){
        header('Location: view/usuario.php?erro=1');
        exit();
    }
}

function exibirDetalhesProdutos($con, $id){
    try {
        $sql = "SELECT id, nome, descricao, preco, estoque, ativo FROM produtos WHERE id = :id";
        $stmt = $con->prepare($sql);
        $stmt->execute(['id' => $id]);
        $produto = $stmt->fetch();
        if (!$produto){
            header('Location: ../index.php?erro=2');
            exit();
        }
        return $produto;
    }catch (PDOException $e){
        header('Location: ../index.php?erro=1');
        exit();
    }
}