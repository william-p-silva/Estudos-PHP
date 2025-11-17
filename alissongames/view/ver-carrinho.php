<?php
session_start();
require_once '../conexao.php';
require_once '../verifica_secao.php';
verificar_acesso(['cliente'], 'tela-login.php');

$carrinho = isset($_SESSION['carrinho']) ? $_SESSION['carrinho'] : [];
$itensCarrinho = [];
$totalGeral = 0.0;
if (!empty($carrinho)) {
    $ids_produtos = array_keys($carrinho);
    $placeholders = implode(',', array_fill(0, count($ids_produtos), '?'));

    try {
        $sql = "SELECT id, nome, preco, estoque FROM produtos WHERE id IN ($placeholders) AND ativo = 1";
        $stmt = $con->prepare($sql);
        $stmt->execute($ids_produtos);
        $produtos_db = $stmt->fetchAll();

        $produtos_por_id = [];
        foreach ($produtos_db as $p) {
            $produtos_por_id[$p['id']] = $p;
        }
    } catch (PDOException $e) {
        header('Location: ../index.php?erro=1');
    }

    foreach ($carrinho as $id_produto => $quantidade) {
        // Se o produto não foi encontrado na DB (ex: foi desativado), remove do carrinho
        if (!isset($produtos_por_id[$id_produto])) {
            unset($_SESSION['carrinho'][$id_produto]);
            continue;
        }
        $produto = $produtos_por_id[$id_produto];

        if ($quantidade > $produto['estoque']) {
            $quantidade = $produto['estoque'];
            $_SESSION['carrinho'][$id_produto] = $quantidade; // Atualiza a sessão
        }
        $subTotal = $produto['preco'] * $quantidade;
        $totalGeral += $subTotal;
        $itensCarrinho[] = [
            'id' => $produto['id'],
            'nome' => $produto['nome'],
            'preco' => $produto['preco'],
            'estoque' => $produto['estoque'],
            'quantidade' => $quantidade,
            'subTotal' => $subTotal
        ];
    }
}

?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameStore</title>
    <link rel="stylesheet" href="style/usuario.css">
    <link rel="stylesheet" href="style/carrinho.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/10339/10339556.png" type="image/x-icon">
</head>

<body>
    <?php
    require_once '../exibir-front.php';
    exibirNavBar();

    ?>
    <main>
        <div class="container-carrinho">

            <h1>Seu Carrinho</h1>

            <div class="carrinho">
            

            <?php foreach ($itensCarrinho as $item): ?>
                <?php $preco_formatado = number_format($item['preco'], 2, ',', '.'); ?>
                <!-- ITEM DO CARRINHO — repetir via PHP -->
                <div class="item-carrinho">
                    
                        <div class="info">
                            <h3><?= $item['nome']?></h3>
                            <p class="preco-item">R$ <?= $preco_formatado ?></p>
                        </div>

                        <div class="qtd">
                            <button class="qtd-btn">-</button>
                            <input type="number" min="1" value="1">
                            <button class="qtd-btn">+</button>
                        </div>

                        

                        <button class="remover">X</button>
                   
                </div>
                <?php endforeach; ?>
                <!-- FIM ITEM -->

            </div>

            <!-- RESUMO -->
            <div class="resumo">
                <h2>Resumo do Pedido</h2>

                <p class="linha">
                    Produtos: <span>R$ <?= $totalGeral ?></span>
                </p>

                <p class="linha">
                    Frete: <span>R$ 25,00</span>
                </p>

                <p class="linha total-final">
                    Total: <span>R$ <?= $totalGeral + 25 ?></span>
                </p>

                <button class="btn-finalizar">Finalizar Compra</button>
            </div>

        </div>

    </main>
</body>


</html>