

<?php

require_once 'conexao.php';
require_once 'verifica_secao.php';
verificar_acesso('admin');

function exibeProduto($con)
{
    try {
        $sql = "SELECT id, nome, descricao, preco, estoque, ativo FROM produtos";
        $stmt = $con->query($sql);
        $produtos = $stmt->fetchAll();
        if (isset($produtos)) {
            foreach ($produtos as $produto) {
                echo "<div class='card-produto'>";
                echo "<p class='preco'>ID: " . $produto['id'] . "</p>";
                echo "<h3>" . $produto['nome'] . "</h3>";
                echo "<p class='preco'>Preço: R$ " . $produto['preco'] . "</p>";
                if ($produto['ativo'] == '1'){
                    $produto['ativo'] = "Ativo";
                }else{
                    $produto['ativo'] = "Inativo";
                }
                echo "<p class='preco'>Status: " . $produto['ativo'] . "</p>";
                echo "<p class='preco'>Estoque: " . $produto['estoque'] . "</p>";
                echo "<div class='acoes'>";
               
                echo "<button class='editar'>Editar</button>";
                echo "<button class='excluir'>Excluir</button>";
                echo "</div>";
                echo "</div>";
            };
        }else{
            echo "<p>Nenhum produto cadastrado.</p>";
        }

    } catch (PDOException $e) {
        header('Location: view/admin.php?erro=1');}
};
?>