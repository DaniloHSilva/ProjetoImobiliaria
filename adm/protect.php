<?php
    if(!isset($_SESSION)){
        session_start();
    }

    if(!isset($_SESSION['id'])){
        die("Você não tem acesso a essa pagina pois não esta logado! <p><a href=\"login.php\">Login</a></p>" );
    }
?>

