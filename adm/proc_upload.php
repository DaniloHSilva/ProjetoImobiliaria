<?php
include('protect.php');
include('../conn.php');


    $msg = false;
    if(isset($_FILES['arquivo'])){
        $extensao = strtolower(substr($_FILES['arquivo']['name'], -4));
        $novo_nome = md5(time()). $extensao;
        $diretorio = "../terrenos/";


        $vTitulo = $_POST["titulo"];
        $vDesc = $_POST["descp"];
        $vCat = $_POST["categ"];
        $vValue = $_POST["valor"];

        move_uploaded_file($_FILES['arquivo']['tmp_name'], $diretorio.$novo_nome);

        $sql_code = "INSERT INTO terrenos (id, titulo, descricao, categoria, valor, foto) VALUES(null, '$vTitulo', '$vDesc', '$vCat', '$vValue', '$novo_nome')";
        if($mysqli->query($sql_code)){
            $msg = "arquivo enviado com sucesso!";
            header('Location: painel.php');
        } else {
            $msg = "falha ao enviar arquivo!";

        }
    }
?>

