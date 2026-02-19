<?php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['id']) || $_SESSION['tipo'] !== 'professor') {
    header("Location: ../login.php");
    exit();
}

$nome_completo = $_SESSION['user'];
$professorID = $_SESSION['id'];
$nome = explode(' ', $nome_completo)[0];

include '../php/db.php';

$query = "SELECT t.TUR_id, t.TUR_nome, 
           COALESCE(dp.DPR_nome, dpe.DPE_nome) AS disciplina
    FROM turma_professor_disciplina tpd
    JOIN turma t ON t.TUR_id = tpd.TPD_TUR_id
    LEFT JOIN disciplinas_predefinidas dp ON dp.DPR_id = tpd.TPD_DIS_id AND tpd.TPD_DIS_tipo = 'predefinida'
    LEFT JOIN disciplinas_personalizadas dpe ON dpe.DPE_id = tpd.TPD_DIS_id AND tpd.TPD_DIS_tipo = 'personalizada'
    WHERE tpd.TPD_PRO_id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $professorID);
$stmt->execute();
$result = $stmt->get_result();

$turmasDisciplinas = [];
while ($row = $result->fetch_assoc()) {
    $turmasDisciplinas[] = $row;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Professor</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<main>
    <div class="sidebar" id="sidebar">
        <button id="menuToggle"><span id="menuIcon">&#9664;</span></button>
        <div class="sidebar_logo"><i class="fa-solid fa-chalkboard-user"id="nav_logo"> Em Sala</i></div>
        <div class="profile">
            <img src="../img/profile-pic-L.png" alt="Foto de perfil do professor" class="foto-sidebar">
            <?php echo "<p>Bem-vindo</br>".$nome."</p>"?>
        </div>
        <nav class="sidebar_nav">
            <ul class="sidebar_nav_links">
                <a href="painel.php"><li class="side_active">Painel</li></a>
                <a href="pesquisar.php"><li>Pesquisar</li></a>
                <a href="configurações.php"><li>Configurações</li></a>
                <a href="../php/logout.php"><li>Sair</li></a>
            </ul>
        </nav>
    </div>
    <div class="content">
        <div class="header">
            <h1>Minhas turmas</h1>
        </div>
        <div class="container">
            <?php
                if (empty($turmasDisciplinas)) {
                    echo "<p style='margin-top:20px; width:500px; color: #af1818; font-weight: bold;'>Você ainda não está vinculado a uma turma.</p>";
                } else {
                    foreach ($turmasDisciplinas as $item) {
                        $idTurma = $item['TUR_id'];
                        $nomeTurma = $item['TUR_nome'];
                        $nomeDisciplina = $item['disciplina'];
                        echo "<a href='turma.php?id=$idTurma'><div class='filha'>$nomeTurma<br><br><span>$nomeDisciplina</span></div></a>";
                    }
                }
            ?>
        </div>
    </div>
</main>

<script src="../js/script.js"></script>
</body>
</html>
