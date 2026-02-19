<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $alunoId = intval($_POST['id']);

    $sql = "SELECT ALR_RES_id FROM aluno_responsavel WHERE ALR_ALU_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $alunoId);
    $stmt->execute();
    $stmt->bind_result($resId);
    $stmt->fetch();
    $stmt->close();

    if ($resId) {
        $stmt = $conn->prepare("DELETE FROM aluno_responsavel WHERE ALR_ALU_id = ?");
        $stmt->bind_param("i", $alunoId);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("DELETE FROM aluno WHERE ALU_id = ?");
        $stmt->bind_param("i", $alunoId);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("SELECT COUNT(*) FROM aluno_responsavel WHERE ALR_RES_id = ?");
        $stmt->bind_param("i", $resId);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count == 0) {
            $stmt = $conn->prepare("DELETE FROM responsavel WHERE RES_id = ?");
            $stmt->bind_param("i", $resId);
            $stmt->execute();
            $stmt->close();
        }

        echo "ok";
    } else {
        echo "Aluno não possui responsável associado.";
    }

} else {
    echo "Requisição inválida.";
}
?>
