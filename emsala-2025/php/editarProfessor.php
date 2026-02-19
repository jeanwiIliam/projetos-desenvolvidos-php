<?php
session_start();

if (isset($_GET['id'])) {
    $idEscola = $_GET['id'];
}
include 'db.php';

if (!isset($_SESSION['user'])) {
    die("Acesso negado!");
}
if (!isset($_POST['id'])) {
    die("ID inválido!");
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idProf = $_POST['id'];
    $novoNome = $_POST['nome'];
    $novoEmail = $_POST['email'];  


    if (!empty($novoNome) && !empty($novoEmail)) {
        $stmt = $conn->prepare("UPDATE professor SET PRO_nome = ?, PRO_email = ? WHERE PRO_id = ?");
        $stmt->bind_param("ssi", $novoNome, $novoEmail, $idProf);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

}

header("Location: ../ambiente/professores.php?id=$idEscola");
exit();
?>