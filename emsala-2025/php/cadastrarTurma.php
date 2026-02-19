<?php
session_start();

if (isset($_GET['id'])) {
    $idEscola = $_GET['id'];
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST['nome'];

    if (!empty($nome)) {
        $stmt = $conn->prepare("INSERT INTO turma (TUR_nome, TUR_AMB_id) VALUES (?, ?)");
        $stmt->bind_param("si", $nome, $idEscola);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

}

header("Location: ../ambiente/turmas.php?id=$idEscola");
exit();
?>