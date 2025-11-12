<?php
if (empty($_POST['nome']) or empty($_POST['txtEmail']) or empty($_POST['senha'])) {
    header('Location: cadastro-admin.php?erro=1');
    exit();
} else {
    require_once 'conexao.php';

    $nome = $_POST['nome'];
    $email = $_POST['txtEmail'];

    $sql = "SELECT email FROM usuarios WHERE email = :email";
    $stmt = $con->prepare($sql);
    $stmt->execute(['email' => $email]);

    if ($stmt->rowCount() == 0) {
        $senha_hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        $perfil = 'admin';

        // Tente executar a inserção
        try {
            $sql = "INSERT INTO usuarios(nome, email, senha, perfil) 
                    VALUES (:nome, :email, :senha, :perfil)";
            $stmt = $con->prepare($sql);
            $stmt->execute([
                'nome' => $nome,
                'email' => $email,
                'senha' => $senha_hash,
                'perfil' => $perfil
            ]);

            // Se o INSERT foi bem-sucedido:
            header('Location: index.php?sucesso=1'); // Redireciona para login
            exit();

        } catch (PDOException $e) {
            // Se houver um erro no banco (ex: problema na conexão, tamanho da coluna)
            // É importante não mostrar o erro cru para o usuário, mas registrar no log.
            // Para estudo, podemos mostrar, mas em produção, use um log.
            // echo "Erro ao cadastrar: " . $e->getMessage();
            header('Location: cadastro-admin.php?erro=3'); // Novo erro para falha do BD
            exit();
        }
    } else {
        header('Location: cadastro-admin.php?erro=2');
        exit();
    }
}
