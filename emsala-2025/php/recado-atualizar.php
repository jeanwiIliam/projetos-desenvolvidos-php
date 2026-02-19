<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

include 'db.php';

if (isset($_POST['recado_id'], $_POST['novo_texto'], $_POST['nova_data'], $_POST['nova_hora'])) {
    $recadoId = intval($_POST['recado_id']);
    $novoTexto = trim($_POST['novo_texto']);
    $novaData = $_POST['nova_data'];
    $novaHora = $_POST['nova_hora'];
    $novaDataHora = "$novaData $novaHora";

    $stmt = $conn->prepare("UPDATE recado SET REC_texto = ?, REC_data_envio = ? WHERE REC_id = ?");
    $stmt->bind_param("ssi", $novoTexto, $novaDataHora, $recadoId);
    $stmt->execute();
    $stmt->close();

    if (!empty($_POST['anexos_remover'])) {
        $anexosParaRemover = explode(',', $_POST['anexos_remover']);

        foreach ($anexosParaRemover as $anexoId) {
            $anexoId = intval($anexoId);
            if ($anexoId > 0) {
                $stmt = $conn->prepare("SELECT RAN_arquivo FROM recado_anexo WHERE RAN_id = ? AND RAN_REC_id = ?");
                $stmt->bind_param("ii", $anexoId, $recadoId);
                $stmt->execute();
                $stmt->bind_result($caminhoArquivo);
                if ($stmt->fetch()) {
                    if (file_exists($caminhoArquivo)) {
                        unlink($caminhoArquivo);
                    }
                }
                $stmt->close();

                $stmt = $conn->prepare("DELETE FROM recado_anexo WHERE RAN_id = ? AND RAN_REC_id = ?");
                $stmt->bind_param("ii", $anexoId, $recadoId);
                $stmt->execute();
                $stmt->close();
            }
        }
    }

    if (isset($_FILES['novos_anexos']) && !empty($_FILES['novos_anexos']['name'][0])) {
        $uploadDir = '../uploads/recados/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        foreach ($_FILES['novos_anexos']['tmp_name'] as $key => $tmpName) {
            $originalName = basename($_FILES['novos_anexos']['name'][$key]);
            $safeName = uniqid() . '_' . $originalName;
            $destino = $uploadDir . $safeName;

            if (move_uploaded_file($tmpName, $destino)) {
                // Anexo é salvo já com o caminho
                $stmt = $conn->prepare("INSERT INTO recado_anexo (RAN_REC_id, RAN_arquivo) VALUES (?, ?)");
                $stmt->bind_param("is", $recadoId, $destino);
                $stmt->execute();
                $stmt->close();
            }
        }
    }

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    echo "Dados incompletos.";
}
?>
