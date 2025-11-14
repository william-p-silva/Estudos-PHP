<?php
session_start();
require_once 'conexao.php';
require_once 'verifica_secao.php';
verificar_acesso('admin');

if (empty($_POST['nome']) or empty($_POST['descricao']) or empty($_POST['preco']) or empty($_POST['estoque']) or !isset($_POST['ativo'])) {
    header('Location: view/produtos.php?erro=1');
    exit();

} else if ($_POST['preco'] <= 0 or $_POST['estoque'] < 0 ){
    header('Location: view/produtos.php?erro=1');
    exit();
}else if ($_POST['ativo'] != '1' and $_POST['ativo'] != '0') {
    header('Location: view/produtos.php?erro=1');
    exit();
}else{
    try{
        $nomeProduto = $_POST['nome'];
        $descricaoProduto = $_POST['descricao'];
        $precoProduto = $_POST['preco'];
        $estoqueProduto = $_POST['estoque'];
        $ativo = $_POST['ativo'];

        $sql = "UPDATE produtos SET nome = :nome, descricao = :descricao, preco = :preco, estoque = :estoque, ativo = :ativo WHERE id = :id";
        $stmt = $con->prepare($sql);
        $stmt->execute([
            ':id' => $_POST['id'],
            ':nome' => $nomeProduto,
            ':descricao' => $descricaoProduto,
            ':preco' => $precoProduto,
            ':estoque' => $estoqueProduto,
            ':ativo' => $ativo
        ]);
        header('Location: view/produtos.php?sucesso=1');
        exit();
    }catch (PDOException $e){
        header('Location: view/produtos.php?erro=1');
        exit();
    }
}