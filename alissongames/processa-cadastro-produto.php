<?php 

session_start();
require_once 'verifica_secao.php';
verificar_acesso('admin');


if (empty($_POST['nome']) or empty($_POST['descricao']) or empty($_POST['preco']) or empty($_POST['estoque']) or !isset($_POST['ativo'])) {
    header('Location: view/cadastro-produto.php?erro=1');
    exit();

} else if ($_POST['preco'] <= 0 or $_POST['estoque'] < 0 ){
    header('Location: view/cadastro-produto.php?erro=1');
    exit();
}else if ($_POST['ativo'] != '1' and $_POST['ativo'] != '0') {
    header('Location: view/cadastro-produto.php?erro=1');
    exit();
}else{
    require_once 'conexao.php';
    try{
        $nomeProduto = $_POST['nome'];
        $descricaoProduto = $_POST['descricao'];
        $precoProduto = $_POST['preco'];
        $estoqueProduto = $_POST['estoque'];
        $ativo = $_POST['ativo'];

        $sql = "INSERT INTO produtos (nome, descricao, preco, estoque, ativo) VALUES (:nome, :descricao, :preco, :estoque, :ativo)";
        $stmt = $con->prepare($sql);
        $stmt->execute([
            ':nome' => $nomeProduto,
            ':descricao' => $descricaoProduto,
            ':preco' => $precoProduto,
            ':estoque' => $estoqueProduto,
            ':ativo' => $ativo
        ]);
        header('Location: view/cadastro-produto.php?sucesso=1');
        exit();
    }catch (PDOException $e){
        header('Location: view/cadastro-produto.php?erro=1');
        exit();
    }
}

?>