<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $aluno_nomes = $_POST['aluno_nome'];
    $aluno_emails = $_POST['aluno_email'];
    $resp_nomes = $_POST['resp_nome'];
    $resp_emails = $_POST['resp_email'];
    $idTurma = $_POST['idTurma'];
    $idEscola = $_POST['idEscola'];

    for ($i = 0; $i < count($aluno_nomes); $i++) {
        $aluno_nome = trim($aluno_nomes[$i]);
        $aluno_email = trim($aluno_emails[$i]);
        $resp_nome = trim($resp_nomes[$i]);
        $resp_email = trim($resp_emails[$i]);

        $checkAluno = $conn->prepare("SELECT ALU_id FROM aluno WHERE ALU_email = ?");
        $checkAluno->bind_param("s", $aluno_email);
        $checkAluno->execute();
        $checkAluno->bind_result($aluno_id_existente);
        $checkAluno->fetch();
        $checkAluno->close();

        if ($aluno_id_existente) {
            continue;
        }

        $ano = date("y");
        $tp = "44";

        do {
            $codigo = $ano . $tp . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $verifica = $conn->prepare("SELECT COUNT(*) FROM aluno WHERE ALU_cod = ?");
            $verifica->bind_param("s", $codigo);
            $verifica->execute();
            $verifica->bind_result($count);
            $verifica->fetch();
            $verifica->close();
        } while ($count > 0);

        $checkResp = $conn->prepare("SELECT RES_id FROM responsavel WHERE RES_email = ? AND RES_AMB_id = ?");
        $checkResp->bind_param("si", $resp_email, $idEscola);
        $checkResp->execute();
        $checkResp->bind_result($resp_id_existente);
        $checkResp->fetch();
        $checkResp->close();

        if (!$resp_id_existente) {
            $insertResp = $conn->prepare("INSERT INTO responsavel (RES_nome, RES_email, RES_cod, RES_AMB_id) VALUES (?, ?, ?, ?)");
            $insertResp->bind_param("sssi", $resp_nome, $resp_email, $codigo, $idEscola);
            $insertResp->execute();
            $resp_id = $insertResp->insert_id;
            $insertResp->close();
        } else {
            $resp_id = $resp_id_existente;
        }

        $insertAluno = $conn->prepare("INSERT INTO aluno (ALU_nome, ALU_email, ALU_cod, ALU_AMB_id, ALU_TUR_id) VALUES (?, ?, ?, ?, ?)");
        $insertAluno->bind_param("sssii", $aluno_nome, $aluno_email, $codigo, $idEscola, $idTurma);
        $insertAluno->execute();
        $aluno_id = $insertAluno->insert_id;
        $insertAluno->close();

        $vinculo = $conn->prepare("INSERT INTO aluno_responsavel (ALR_ALU_id, ALR_RES_id) VALUES (?, ?)");
        $vinculo->bind_param("ii", $aluno_id, $resp_id);
        $vinculo->execute();
        $vinculo->close();
    }

    header("Location: ../ambiente/turmas-cadastros.php?id=$idTurma");
    exit();
}
?>
