<?php 
function exibirNavBar(){
    echo"
    <header class='header'>
        <a href='../index.php' class='logo-link'>
            <div class='logo'>GameStore</div>
        </a>

        <input type='text' class='search' placeholder='Buscar produtos...'>

        <nav class='menu'>
            <a href='#'>Jogos</a>
            <a href='#'>Consoles</a>
            <a href='#'>Acessórios</a>
            <a href='#'>Promoções</a>
        </nav>

        <div class='icons'>
            <a href='view/ver-carrinho.php'><span class='icon'>🛒</span></a>
            <a href='view/tela-login.php'><span class='icon'>👤</span></a>
        </div>
    </header>
    ";
}
?>