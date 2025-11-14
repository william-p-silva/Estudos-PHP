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
