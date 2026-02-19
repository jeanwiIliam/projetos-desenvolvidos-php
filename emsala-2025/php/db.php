<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "emsala";
$port = 3307;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

mysqli_query($conn, "SET NAMES 'utf8'");
mysqli_query($conn, "SET character_set_connection=utf8");
mysqli_query($conn, "SET character_set_client=utf8");
date_default_timezone_set('America/Manaus');
?>
