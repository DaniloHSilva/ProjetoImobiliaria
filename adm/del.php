<?php
    include('protect.php');
    include('../conn.php');
   
    $pag = intval($_GET['id']);
    $sql = "DELETE FROM venda WHERE id = '$pag'";
    $sql_query = $mysqli->query($sql) or die ($mysqli->error);
    header("Location: painel.php");

?>