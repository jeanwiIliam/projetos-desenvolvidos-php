<?php
    $host = "localhost";
    $user = "root";
    $senha = "";
    $database = "three_hugs";
    $port = 3307;

    $con = mysqli_connect($host, $user, $senha, $database, $port);
    if($con->connect_errno){
        echo "Erro de conexão";
    }

    mysqli_query($con, "SET NAMES 'utf8'");
    mysqli_query($con, "SET character_set_connection=utf8");
    mysqli_query($con, "SET character_set_client=utf8");
?>