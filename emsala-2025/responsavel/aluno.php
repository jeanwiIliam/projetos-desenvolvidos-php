<?php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['id']) || $_SESSION['tipo'] !== 'responsavel') {
    header("Location: ../login.php");
    exit();
}

include '../php/db.php';

if (!isset($_GET['id'])) {
    echo "Aluno não especificado.";
    exit();
}

$alunoID = intval($_GET['id']);

$nome_completo = $_SESSION['user'];
$nome = explode(' ', $nome_completo)[0];

$queryVerifica = "SELECT 1 FROM aluno_responsavel 
                  WHERE ALR_ALU_id = ? AND ALR_RES_id = ?";
$stmtVerifica = $conn->prepare($queryVerifica);
$stmtVerifica->bind_param("ii", $alunoID, $_SESSION['id']);
$stmtVerifica->execute();
$resultVerifica = $stmtVerifica->get_result();

if ($resultVerifica->num_rows === 0) {
    echo "Você não tem permissão para acessar os dados deste aluno.";
    exit();
}

$queryTurma = "SELECT a.ALU_nome, t.TUR_id, t.TUR_nome
               FROM aluno a
               JOIN turma t ON a.ALU_TUR_id = t.TUR_id
               WHERE a.ALU_id = ?";
$stmtTurma = $conn->prepare($queryTurma);
$stmtTurma->bind_param("i", $alunoID);
$stmtTurma->execute();
$resultTurma = $stmtTurma->get_result();
$turma = $resultTurma->fetch_assoc();

$disciplinas = [];

if ($turma) {
    $nomeAluno = $turma['ALU_nome'];
    $idTurma = $turma['TUR_id'];
    $nomeTurma = $turma['TUR_nome'];

    $queryDisciplinas = "SELECT COALESCE(dp.DPR_nome, dpe.DPE_nome) AS disciplina
                         FROM turma_professor_disciplina tpd
                         LEFT JOIN disciplinas_predefinidas dp ON dp.DPR_id = tpd.TPD_DIS_id AND tpd.TPD_DIS_tipo = 'predefinida'
                         LEFT JOIN disciplinas_personalizadas dpe ON dpe.DPE_id = tpd.TPD_DIS_id AND tpd.TPD_DIS_tipo = 'personalizada'
                         WHERE tpd.TPD_TUR_id = ?";
    $stmtDisciplinas = $conn->prepare($queryDisciplinas);
    $stmtDisciplinas->bind_param("i", $idTurma);
    $stmtDisciplinas->execute();
    $resultDisciplinas = $stmtDisciplinas->get_result();

    while ($row = $resultDisciplinas->fetch_assoc()) {
        $disciplinas[] = $row['disciplina'];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disciplinas</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<main>
    <div class="sidebar" id="sidebar">
        <button id="menuToggle"><span id="menuIcon">&#9664;</span></button>
            <div class="sidebar_logo"><i class="fa-solid fa-chalkboard-user"id="nav_logo"> Em Sala</i></div>
        <div class="profile">
            <img src="../img/profile-pic-L.png" alt="Foto de perfil do responsável" class="foto-sidebar">
            <?php echo "<p>Bem-vindo</br>" . $nome . "</p>" ?>
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
            <h1><?php echo "$nomeAluno - $nomeTurma"; ?></h1>
        </div>
            <div class="container">
                <?php
                if (!empty($disciplinas)) {
                    foreach ($disciplinas as $disciplina) {
                        $disciplinaEncoded = urlencode($disciplina);
                        echo "<a href='turma.php?id=$idTurma&disc=$disciplinaEncoded&aluno=" . urlencode($nomeAluno) . "&ida=$alunoID' class='link-filha'>
                            <div class='filha'>$disciplina</div>
                        </a>";
                    }
                } else {
                    echo "<p>Este aluno ainda não possui disciplinas vinculadas à sua turma.</p>";
                }
                ?>
            </div>

    </div>
</main>
<script src="../js/script.js"></script>
</body>
</html>
