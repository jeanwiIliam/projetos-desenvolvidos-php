<?php
require_once "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alu_id = $_POST['ALU_id'];
    $alu_nome = $_POST['ALU_nome'];
    $alu_email = $_POST['ALU_email'];

    $res_id = $_POST['RES_id'];
    $res_nome = $_POST['RES_nome'];
    $res_email = $_POST['RES_email'];

    $turma_id = $_POST['id'];

    $sqlAluno = "UPDATE aluno SET ALU_nome = ?, ALU_email = ? WHERE ALU_id = ?";
    $stmtAluno = $conn->prepare($sqlAluno);
    $stmtAluno->bind_param("ssi", $alu_nome, $alu_email, $alu_id);
    $stmtAluno->execute();

    $sqlResponsavel = "UPDATE responsavel SET RES_nome = ?, RES_email = ? WHERE RES_id = ?";
    $stmtResponsavel = $conn->prepare($sqlResponsavel);
    $stmtResponsavel->bind_param("ssi", $res_nome, $res_email, $res_id);
    $stmtResponsavel->execute();

    header("Location: ../ambiente/dadosTurma.php?id=" . $turma_id);
    exit;
} else {
    header("Location: index.php");
    exit;
}
