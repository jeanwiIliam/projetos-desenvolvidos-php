<?php
session_start();

if (isset($_GET['id'])) {
    $idEscola = $_GET['id'];
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];  

    $ano = date("y");
    $tp = "22";

    do {
        $codigo = $ano . $tp . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $verifica = $conn->prepare("SELECT COUNT(*) FROM professor WHERE PRO_cod = ?");
        $verifica->bind_param("s", $codigo);
        $verifica->execute();
        $verifica->bind_result($count);
        $verifica->fetch();
        $verifica->close();
    } while ($count > 0);

    if (!empty($nome) && !empty($email)) {
        $stmt = $conn->prepare("INSERT INTO professor (PRO_nome, PRO_email, PRO_cod, PRO_AMB_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $nome, $email, $codigo , $idEscola);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

}

header("Location: ../ambiente/professores.php?id=$idEscola");
exit();
?>