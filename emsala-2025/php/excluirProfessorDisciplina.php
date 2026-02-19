<?php
include 'db.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $conn->prepare("DELETE FROM turma_professor_disciplina WHERE TPD_id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "ok";
    } else {
        echo "erro";
    }
    $stmt->close();
} else {
    echo "erro";
}
?>
