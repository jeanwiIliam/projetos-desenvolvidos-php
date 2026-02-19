<?php
include 'db.php';

if (isset($_GET['recado_id'])) {
    $id = intval($_GET['recado_id']);
    $res = $conn->query("SELECT * FROM recado_anexo WHERE RAN_REC_id = $id");

    $anexos = [];
    while ($a = $res->fetch_assoc()) {
        $anexos[] = [
            'id' => $a['RAN_id'],
            'caminho' => $a['RAN_arquivo'],
            'nome' => preg_replace('/^[^_]*_/', '', basename($a['RAN_arquivo']))
        ];
    }

    echo json_encode($anexos);
}
?>

