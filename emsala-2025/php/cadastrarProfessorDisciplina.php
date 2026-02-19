<?php
session_start();

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $professores = $_POST['professor'];
    $disciplinas = $_POST['disciplina'];
    $novasDisciplinas = $_POST['nova_disciplina'];
    $idTurma = intval($_POST['idTurma']);
    $idEscola = intval($_POST['idEscola']);

    for ($i = 0; $i < count($professores); $i++) {
        $professorId = intval($professores[$i]);
        $disciplinaId = null;
        $tipoDisciplina = '';

        if ($disciplinas[$i] === 'adicionar') {
            $novaDisciplina = trim($novasDisciplinas[$i]);

            if ($novaDisciplina !== '') {
                $stmt = $conn->prepare("SELECT DPE_id FROM disciplinas_personalizadas WHERE DPE_nome = ? AND DPE_AMB_id = ?");
                $stmt->bind_param("si", $novaDisciplina, $idEscola);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $disciplinaRow = $result->fetch_assoc();
                    $disciplinaId = $disciplinaRow['DPE_id'];
                } else {
                    $stmt = $conn->prepare("INSERT INTO disciplinas_personalizadas (DPE_nome, DPE_AMB_id) VALUES (?, ?)");
                    $stmt->bind_param("si", $novaDisciplina, $idEscola);
                    $stmt->execute();
                    $disciplinaId = $stmt->insert_id;
                }
                $tipoDisciplina = 'personalizada';
            } else {
                continue;
            }
        } else {
            $disciplinaId = intval($disciplinas[$i]);
            $tipoDisciplina = 'predefinida';
        }

        $stmt = $conn->prepare("INSERT INTO turma_professor_disciplina (TPD_TUR_id, TPD_PRO_id, TPD_DIS_tipo, TPD_DIS_id) VALUES (?, ?, ?, ?) ");
        $stmt->bind_param("iisi", $idTurma, $professorId, $tipoDisciplina, $disciplinaId);
        $stmt->execute();
    }

    header("Location: ../ambiente/turmas-cadastros.php?id=$idTurma");
    exit();
} else {
    echo "Acesso inválido.";
}
?>
