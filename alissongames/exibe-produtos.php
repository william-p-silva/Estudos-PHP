

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
                echo "<div class='container-produtos'>";
                echo "<div class='card-produto'>";
                echo "<p class='preco'>ID: " . $produto['id'] . "</p>";
                echo "<h3>" . $produto['nome'] . "</h3>";
                echo "<p class='preco'>Preço: R$ " . $produto['preco'] . "</p>";
                $produto['ativo'] = ($produto['ativo'] == '1') ? 'Ativo' : 'Inativo';
                echo "<p class='preco'>Status: " . $produto['ativo'] . "</p>";
                echo "<p class='preco'>Estoque: " . $produto['estoque'] . "</p>";
                echo "<div class='acoes'>";
                echo "<p class='justo'>Descrição: " . $produto['descricao'] . "</p>";
                echo "</div>";
                echo "<div class='acoes'>";
               
                echo "<a href='alterar-produtos.php?id=".$produto['id'] ."' class='editar'>Editar</a>";
                echo "<button class='excluir' onclick='confirmarExclusao(" . $produto['id'] . ", \"" . $produto['nome'] . "\")'>Excluir</button>";

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
