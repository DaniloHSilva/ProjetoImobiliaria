<?php
    $host = "localhost";
    $database = "tiagoimoveisdb";
    $user = "root";
    $pass = "";

    $mysqli = new mysqli($host, $user, $pass, $database);
	$mysqli->set_charset("utf8mb4");



    if ($mysqli->connect_errno){
        echo "connection faild: ( ". $mysqli->connect_errno . ") ". $mysqli->connect_errno;
    }
?>