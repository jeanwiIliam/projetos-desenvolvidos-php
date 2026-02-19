<?php
include 'db.php';

$idAluno = $_GET['id_aluno'] ?? null;

if (!$idAluno) {
    echo json_encode([]);
    exit();
}

$sql = "SELECT r.RES_nome, r.RES_email
        FROM aluno_responsavel ar
        JOIN responsavel r ON r.RES_id = ar.ALR_RES_id
        WHERE ar.ALR_ALU_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idAluno);
$stmt->execute();
$stmt->bind_result($nome, $email);

$responsaveis = [];
while ($stmt->fetch()) {
    $responsaveis[] = ['nome' => $nome, 'email' => $email];
}
$stmt->close();

header('Content-Type: application/json');
echo json_encode($responsaveis);
