<?php
session_start();
require_once 'conexao.php';
require_once 'verifica_secao.php';

// Apenas 'clientes' podem ver o carrinho
verificar_acesso('cliente');

// Inicializa o carrinho se estiver vazio
$carrinho = $_SESSION['carrinho'] ?? [];
$produtos_no_carrinho = [];
$total_geral = 0;

if (!empty($carrinho)) {
    // 1. Buscar todos os produtos do carrinho na base de dados de uma só vez
    $ids_produtos = array_keys($carrinho);
    $placeholders = implode(',', array_fill(0, count($ids_produtos), '?'));
    
    $sql = "SELECT id, nome, preco, estoque FROM produtos WHERE id IN ($placeholders) AND ativo = 1";
    $stmt = $con->prepare($sql);
    $stmt->execute($ids_produtos);
    $produtos_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 2. Mapear produtos por ID para fácil acesso e verificar stock
    $produtos_por_id = [];
    foreach ($produtos_db as $p) {
        $produtos_por_id[$p['id']] = $p;
    }

    // 3. Construir a lista final do carrinho com dados atualizados
    foreach ($carrinho as $id_produto => $quantidade) {
        // Se o produto não foi encontrado na DB (ex: foi desativado), remove do carrinho
        if (!isset($produtos_por_id[$id_produto])) {
            unset($_SESSION['carrinho'][$id_produto]);
            continue;
        }

        $produto = $produtos_por_id[$id_produto];
        
        // Se a quantidade no carrinho for maior que o stock, ajusta
        if ($quantidade > $produto['estoque']) {
            $quantidade = $produto['estoque'];
            $_SESSION['carrinho'][$id_produto] = $quantidade; // Atualiza a sessão
        }
        
        $subtotal = $quantidade * $produto['preco'];
        $total_geral += $subtotal;

        $produtos_no_carrinho[] = [
            'id' => $id_produto,
            'nome' => $produto['nome'],
            'preco' => $produto['preco'],
            'estoque' => $produto['estoque'],
            'quantidade' => $quantidade,
            'subtotal' => $subtotal
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f4f4f4; }
        .total { font-size: 1.2em; font-weight: bold; text-align: right; }
        .update-form { display: flex; align-items: center; }
        .update-form input[type="number"] { width: 60px; text-align: center; }
        .btn { padding: 5px 10px; cursor: pointer; }
        .btn-remover { background-color: #ef4444; color: white; border: none; }
        .btn-finalizar { background-color: #16a34a; color: white; border: none; padding: 10px 20px; font-size: 1.1em; }
        .carrinho-vazio { text-align: center; font-size: 1.2em; color: #777; }
    </style>
</head>
<body>

    <h1>Meu Carrinho de Compras</h1>

    <?php if (empty($produtos_no_carrinho)): ?>
        <p class="carrinho-vazio">O seu carrinho está vazio.</p>
        <a href="view/produtos.php">Continuar a comprar</a>
    <?php else: ?>
        <form action="update_carrinho.php" method="POST">
            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Preço Unit.</th>
                        <th>Quantidade</th>
                        <th>Subtotal</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos_no_carrinho as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nome']) ?></td>
                            <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                            <td>
                                <!-- Formulário de Atualização -->
                                <div class="update-form">
                                    <input type="number" name="quantidade[<?= $item['id'] ?>]" value="<?= $item['quantidade'] ?>" min="0" max="<?= $item['estoque'] ?>">
                                </div>
                            </td>
                            <td>R$ <?= number_format($item['subtotal'], 2, ',', '.') ?></td>
                            <td>
                                <!-- Botão Remover -->
                                <a href="remover_item.php?id=<?= $item['id'] ?>" class="btn btn-remover">Remover</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="total">Total Geral:</td>
                        <td class="total">R$ <?= number_format($total_geral, 2, ',', '.') ?></td>
                    </tr>
                </tfoot>
            </table>
            
            <br>
            <button type="submit" class="btn">Atualizar Quantidades</button>
            <a href="finalizar_pedido.php" class="btn btn-finalizar" style="text-decoration: none; float: right;">Finalizar Pedido</a>
        </form>
    <?php endif; ?>

</body>
</html>