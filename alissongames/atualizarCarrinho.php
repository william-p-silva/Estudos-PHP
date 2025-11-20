<?php 
require_once 'conexao.php';
session_start();
require_once 'verifica_secao.php';
verificar_acesso(['cliente'], 'view/tela-login.php');

if (!isset($_POST['quantidade']) || !is_array($_POST['quantidade'])) {
    header('Location: ver_carrinho.php?erro=dados_invalidos');
    exit();
}

// Se o carrinho não existir, não há nada a fazer
if (!isset($_SESSION['carrinho'])) {
    header('Location: ver_carrinho.php');
    exit();
}

$quantidades = $_POST['quantidade'];

try {
    // 1. Obter todos os produtos relevantes do carrinho para verificar o stock
    $ids_produtos = array_keys($quantidades);
    if (empty($ids_produtos)) {
        header('Location: ver_carrinho.php');
        exit();
    }
    
    $placeholders = implode(',', array_fill(0, count($ids_produtos), '?'));
    $sql = "SELECT id, estoque FROM produtos WHERE id IN ($placeholders)";
    $stmt = $con->prepare($sql);
    $stmt->execute($ids_produtos);
    $produtos_db = $stmt->fetchAll(PDO::FETCH_KEY_PAIRED); // [id => estoque]

    // 2. Iterar sobre as quantidades enviadas e atualizar a sessão
    foreach ($quantidades as $id_produto => $quantidade) {
        $id_produto = (int)$id_produto;
        $quantidade = (int)$quantidade;

        // Se o produto não existe na sessão ou no DB, ignora
        if (!isset($_SESSION['carrinho'][$id_produto]) || !isset($produtos_db[$id_produto])) {
            continue;
        }

        // Se a quantidade for 0 ou menos, remove o item
        if ($quantidade <= 0) {
            unset($_SESSION['carrinho'][$id_produto]);
            continue;
        }

        // Se a quantidade desejada excede o stock, limita ao stock
        $stock_disponivel = $produtos_db[$id_produto];
        if ($quantidade > $stock_disponivel) {
            $quantidade = $stock_disponivel;
        }

        // Atualiza a sessão
        $_SESSION['carrinho'][$id_produto] = $quantidade;
    }

    header('Location: view/ver-carrinho.php?sucesso=atualizado');
    exit();

} catch (PDOException $e) {
    header('Location: ver_carrinho.php?erro=db');
    exit();
}