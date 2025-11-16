<?php
session_start();
require_once 'conexao.php';
require_once 'verifica_secao.php';
verificar_acesso(['cliente'], 'view/tela-login.php');


if (!isset($_POST['idProduto']) or !is_numeric($_POST['idProduto'])) {
    header('Location: index.php?erro=2');
    exit();
}
if (!isset($_POST['qtd']) or !is_numeric($_POST['qtd'])) {
    header('Location: index.php?erro=2');
    exit();
}
$idProduto = (int)$_POST['idProduto'];
$qtdProdutoAdd = (int)$_POST['qtd'];
try {
    // 1. Verificar o stock atual do produto
    $sql = "SELECT nome, estoque FROM produtos WHERE id = :idProduto AND ativo = 1";
    $stmt = $con->prepare($sql);
    $stmt->execute(['idProduto' => $idProduto]);
    $produto = $stmt->fetch();
    // Se o produto não existe ou não está ativo
    if (!$produto) {
        header('Location: index.php?erro=2');
        exit();
    }
    $estoqueDisponivel = (int)$produto['estoque'];
    // 2. Inicializar o carrinho na sessão se não existir
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }
    // 3. Verificar a quantidade já existente no carrinho
    $quantidadeNoCarrinho = 0;
    if (isset($_SESSION['carrinho'][$idProduto])) {
        $quantidadeNoCarrinho = (int)$_SESSION['carrinho'][$idProduto];
    }
    $qtdProdutoDesejada = $qtdProdutoAdd + $quantidadeNoCarrinho;
    // 4. Verificar se a quantidade total (carrinho + adicionar) excede o stock
    if ($qtdProdutoDesejada > $estoqueDisponivel) {
        header('Location: view/visao-produto.php?erro=2');
        exit();
    }
    // 5. Adicionar o produto ao carrinho
    $_SESSION['carrinho'][$idProduto] = $qtdProdutoDesejada;

    // Redireciona para a página do carrinho para ver o item adicionado
    header('Location: ver-carrinho.php?sucesso=1');
    exit();
} catch (PDOException $e) {
    header('Location: index.php?erro=1');
    exit();
}
