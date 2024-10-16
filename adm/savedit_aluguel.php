<?php
include('protect.php');
include('../conn.php');

if(isset($_POST['update'])){
    $id = $_POST['id'];
    $vTitulo = $_POST['titulo'];
    $vDesc = $_POST['descp'];
    $vCat = $_POST['categ'];
    $vValue = $_POST['valor'];
    $vEndereco = $_POST['endereco'];
    $vBairro = $_POST['bairro'];
    $vCidade = $_POST['cidade'];
    $vEstado = $_POST['estado'];
    $vCep = $_POST['cep'];
    $vAreaTotal = $_POST['area_total'];
    $vAreaConstruida = $_POST['area_construida'];
    $vNumQuartos = $_POST['num_quartos'];
    $vNumBanheiros = $_POST['num_banheiros'];
    $vNumVagas = $_POST['num_vagas'];

    // Escapar dados para evitar SQL Injection
    $id = $mysqli->real_escape_string($id);
    $vTitulo = $mysqli->real_escape_string($vTitulo);
    $vDesc = $mysqli->real_escape_string($vDesc);
    $vCat = $mysqli->real_escape_string($vCat);
    $vValue = $mysqli->real_escape_string($vValue);
    $vEndereco = $mysqli->real_escape_string($vEndereco);
    $vBairro = $mysqli->real_escape_string($vBairro);
    $vCidade = $mysqli->real_escape_string($vCidade);
    $vEstado = $mysqli->real_escape_string($vEstado);
    $vCep = $mysqli->real_escape_string($vCep);
    $vAreaTotal = $mysqli->real_escape_string($vAreaTotal);
    $vAreaConstruida = $mysqli->real_escape_string($vAreaConstruida);
    $vNumQuartos = $mysqli->real_escape_string($vNumQuartos);
    $vNumBanheiros = $mysqli->real_escape_string($vNumBanheiros);
    $vNumVagas = $mysqli->real_escape_string($vNumVagas);

    $sql_update = "UPDATE aluguel SET 
        titulo='$vTitulo', 
        descricao='$vDesc', 
        categoria='$vCat', 
        valor='$vValue', 
        endereco='$vEndereco',
        bairro='$vBairro',
        cidade='$vCidade',
        estado='$vEstado',
        cep='$vCep',
        area_total='$vAreaTotal',
        area_construida='$vAreaConstruida',
        num_quartos='$vNumQuartos',
        num_banheiros='$vNumBanheiros',
        num_vagas='$vNumVagas'
        WHERE id='$id'";

    $result = $mysqli->query($sql_update);

    if ($result) {
        header("Location: painel.php");
    } else {
        echo "Erro ao atualizar: " . $mysqli->error;
    }
}
?>

