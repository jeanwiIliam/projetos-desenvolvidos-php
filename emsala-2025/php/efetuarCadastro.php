<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("INSERT INTO administrador (ADM_nome, ADM_email, ADM_senha) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $email, $senha);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    
    header("Location: ../login.php");
    exit();
}
?>
