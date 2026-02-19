<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

include 'db.php';

if (isset($_POST['recado_id'])) {
    $recadoId = intval($_POST['recado_id']);

    $resAnexos = $conn->query("SELECT RAN_arquivo FROM recado_anexo WHERE RAN_REC_id = $recadoId");
    while ($anexo = $resAnexos->fetch_assoc()) {
        $caminho = $anexo['RAN_arquivo'];
        if (file_exists($caminho)) {
            unlink($caminho);
        }
    }

    $conn->query("DELETE FROM recado_anexo WHERE RAN_REC_id = $recadoId");
    $conn->query("DELETE FROM recado WHERE REC_id = $recadoId");

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    echo "ID do recado não fornecido.";
}
