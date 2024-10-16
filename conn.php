<?php
    $host = "sql212.infinityfree.com";
    $database = "if0_37302945_tiagoimoveisdb";
    $user = "if0_37302945";
    $pass = "AvengZypWDyL";

    $mysqli = new mysqli($host, $user, $pass, $database);
	$mysqli->set_charset("utf8mb4");



    if ($mysqli->connect_errno){
        echo "connection faild: ( ". $mysqli->connect_errno . ") ". $mysqli->connect_errno;
    }
?>