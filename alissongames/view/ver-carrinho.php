<?php
session_start();
require_once '../conexao.php';
require_once '../verifica_secao.php';

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
    <title>GameStore</title>
    <link rel="stylesheet" href="style/usuario.css">
    <link rel="stylesheet" href="style/carrinho.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/10339/10339556.png" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
    <?php
    require_once '../exibir-front.php';
    exibirNavBar();

    ?>
    <main>
    <h1 class="text-3xl font-bold mb-6">Meu Carrinho de Compras</h1>

<?php if (empty($produtos_no_carrinho)): ?>
    <p class="text-gray-600 text-lg">O seu carrinho está vazio.</p>
    <a href="view/produtos.php" 
       class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
        Continuar a comprar
    </a>
<?php else: ?>
    <form action="../atualizarCarrinho.php" method="POST" class="space-y-6">

        <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold border-b">Produto</th>
                    <th class="px-4 py-3 text-left font-semibold border-b">Preço Unit.</th>
                    <th class="px-4 py-3 text-left font-semibold border-b">Quantidade</th>
                    <th class="px-4 py-3 text-left font-semibold border-b">Subtotal</th>
                    <th class="px-4 py-3 text-left font-semibold border-b">Ação</th>
                </tr>
            </thead>

            <tbody class="bg-white">
                <?php foreach ($produtos_no_carrinho as $item): ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3"><?= htmlspecialchars($item['nome']) ?></td>

                        <td class="px-4 py-3">R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>

                        <td class="px-4 py-3">
                            <input 
                                type="number" 
                                name="quantidade[<?= $item['id'] ?>]" 
                                value="<?= $item['quantidade'] ?>" 
                                min="0" 
                                max="<?= $item['estoque'] ?>"
                                class="w-20 border border-gray-300 rounded-lg px-2 py-1 focus:ring focus:ring-blue-300"
                            >
                        </td>

                        <td class="px-4 py-3">R$ <?= number_format($item['subtotal'], 2, ',', '.') ?></td>

                        <td class="px-4 py-3">
                            <a href="remover_item.php?id=<?= $item['id'] ?>" 
                               class="text-red-600 hover:text-red-800 font-medium">
                                Remover
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

            <tfoot class="bg-gray-100">
                <tr>
                    <td colspan="4" class="px-4 py-3 text-right font-semibold text-lg">Total Geral:</td>
                    <td class="px-4 py-3 font-semibold text-lg">
                        R$ <?= number_format($total_geral, 2, ',', '.') ?>
                    </td>
                </tr>
            </tfoot>
        </table>

        <div class="flex items-center justify-between mt-4">
            <button type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Atualizar Quantidades
            </button>

            <a href="finalizar_pedido.php" 
               class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Finalizar Pedido
            </a>
        </div>

    </form>
<?php endif; ?>

    </main>
</body>


</html>