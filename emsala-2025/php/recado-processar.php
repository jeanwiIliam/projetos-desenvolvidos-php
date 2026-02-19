<?php
session_start();
include '../php/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$professorId = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tpd_id = $_POST['tpd_id'];
    $tipo = $_POST['destino'];
    $mensagem = trim($_POST['mensagem']);

    $alunoId = null;
    if ($_POST['destino'] === 'individual') {
        $alunoId = $_POST['aluno_id'];
    }
    
    $data_envio = $_POST['data_envio'] ?? '';

    $programado = (!empty($data_envio) && strtotime($data_envio) > time()) ? 1 : 0;
    $data_envio_final = !empty($data_envio) ? $data_envio : date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO recado 
        (REC_TPD_id, REC_PRO_id, REC_ALU_id, REC_texto, REC_programado, REC_data_envio, REC_tipo) 
        VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "iiisiss",
        $tpd_id,
        $professorId,
        $alunoId,
        $mensagem,
        $programado,
        $data_envio_final,
        $tipo
    );
    $stmt->execute();

    $recado_id = $stmt->insert_id;
    $stmt->close();

    // Verificação de anexos múltiplos
    if (!empty($_FILES['arquivos']['name'][0])) {
        $diretorioDestino = '../uploads/recados/';
        if (!is_dir($diretorioDestino)) {
            mkdir($diretorioDestino, 0777, true);
        }

        foreach ($_FILES['arquivos']['tmp_name'] as $index => $tmpName) {
            if ($_FILES['arquivos']['error'][$index] === UPLOAD_ERR_OK) {
                $nomeOriginal = basename($_FILES['arquivos']['name'][$index]);
                $nomeFinal = uniqid() . '_' . $nomeOriginal;
                $caminhoCompleto = $diretorioDestino . $nomeFinal;

                if (move_uploaded_file($tmpName, $caminhoCompleto)) {
                    $stmt = $conn->prepare("INSERT INTO recado_anexo (RAN_REC_id, RAN_arquivo) VALUES (?, ?)");
                    $stmt->bind_param("is", $recado_id, $caminhoCompleto);
                    $stmt->execute();
                    $stmt->close();
                }
            }
        }
    }

    header("Location: ../professor/recados.php?id=" . getTurmaId($conn, $tpd_id));
    exit();
}

// Função auxiliar para voltar à turma
function getTurmaId($conn, $tpd_id) {
    $res = $conn->query("SELECT TPD_TUR_id FROM turma_professor_disciplina WHERE TPD_id = $tpd_id");
    if ($res->num_rows > 0) {
        return $res->fetch_assoc()['TPD_TUR_id'];
    }
    return 0;
}
?>
