<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    
</body>
</html>
<?php
if (isset($_GET) and isset($_GET['msg']) == 'logout-sucesso') {
    header('Location: view/tela-login.php?msg=logout-sucesso');
} else {
    header('Location: view/tela-login.php');
}
