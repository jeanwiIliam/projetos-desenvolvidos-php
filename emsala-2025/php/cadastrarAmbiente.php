<?php
session_start();

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST['nome'];
    $adminID = $_SESSION['id'] ?? null;

    if (!empty($nome) && !empty($adminID)) {
        $stmt = $conn->prepare("INSERT INTO ambiente (AMB_nome, AMB_ADM_id) VALUES (?, ?)");
        $stmt->bind_param("si", $nome, $adminID);
        $stmt->execute();
        $stmt->close();
    }

}

header('Location: ../painel.php');
exit();
?>