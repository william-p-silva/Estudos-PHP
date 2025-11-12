<?php 
    $dbname = "loja";
    $host = "localhost";
    $user = "root";
    $pass = "";
    try {
        // Criando a conexão PDO
        $con = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Ativa o modo de erros do PDO
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Define o padrão de retorno como array associativo
        ]);
    } catch (PDOException $e) {
        // Em caso de erro, exibe a mensagem e encerra o script
        die("Erro na conexão: " . $e->getMessage());
    }

?>