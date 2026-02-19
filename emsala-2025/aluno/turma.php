<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$nome_completo = $_SESSION['user'];
$nome = explode(' ', $nome_completo)[0];

include '../php/db.php';

$nomeTurma = "";
$nomeDisciplina = "";
$nomeProfessor = "";
$alunos = [];

if (isset($_GET['id']) && isset($_GET['disc'])) {
    $idTurma = intval($_GET['id']);
    $disciplinaSelecionada = urldecode($_GET['disc']);

    $resTurma = $conn->query("SELECT TUR_nome FROM turma WHERE TUR_id = $idTurma");
    if ($resTurma->num_rows > 0) {
        $nomeTurma = $resTurma->fetch_assoc()['TUR_nome'];
    }

    $query = "SELECT tpd.TPD_DIS_id, tpd.TPD_DIS_tipo, 
                     COALESCE(dp.DPR_nome, dpe.DPE_nome) AS nome_disciplina, 
                     p.PRO_nome 
              FROM turma_professor_disciplina tpd
              LEFT JOIN disciplinas_predefinidas dp ON dp.DPR_id = tpd.TPD_DIS_id AND tpd.TPD_DIS_tipo = 'predefinida'
              LEFT JOIN disciplinas_personalizadas dpe ON dpe.DPE_id = tpd.TPD_DIS_id AND tpd.TPD_DIS_tipo = 'personalizada'
              JOIN professor p ON p.PRO_id = tpd.TPD_PRO_id
              WHERE tpd.TPD_TUR_id = $idTurma";

    $res = $conn->query($query);
    while ($row = $res->fetch_assoc()) {
        if ($row['nome_disciplina'] === $disciplinaSelecionada) {
            $nomeDisciplina = $row['nome_disciplina'];
            $nomeProfessor = $row['PRO_nome'];
            break;
        }
    }

    $resAlunos = $conn->query("SELECT ALU_nome FROM aluno WHERE ALU_TUR_id = $idTurma");
    while ($row = $resAlunos->fetch_assoc()) {
        $alunos[] = $row['ALU_nome'];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel da Turma</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<main>
    <div class="sidebar" id="sidebar">
        <button id="menuToggle"><span id="menuIcon">&#9664;</span></button>
            <div class="sidebar_logo"><i class="fa-solid fa-chalkboard-user"id="nav_logo"> Em Sala</i></div>
        <div class="profile">
            <img src="../img/profile-pic-L.png" alt="Foto de perfil do aluno" class="foto-sidebar">
            <?php echo "<p>Bem-vindo<br>$nome</p>"; ?>
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
        <?php echo "<h1 class='titulo1'>$nomeTurma</h1>
                    <h2 class='titulo2'>$nomeDisciplina</h2>"; ?>

        <div class="panel_navs">
            <a href="turma.php?id=<?= $idTurma ?>&disc=<?= urlencode($nomeDisciplina) ?>" class="active-link">Turma</a>
            <a href="recados.php?id=<?= $idTurma ?>&disc=<?= urlencode($nomeDisciplina) ?>">Recados</a>
        </div>

        <div class="header">
            <h2>Professor</h2>
        </div>
        <div class="container">
            <?php
            if ($nomeProfessor) {
                echo "<div class='card'>
                        <div class='profile-pic'><img src='../img/profile-pic-D.png' class='foto-card'></div>
                        <div class='profile-name'>$nomeProfessor</div>
                      </div>";
            } else {
                echo "<p>Nenhum professor encontrado para essa disciplina.</p>";
            }
            ?>
        </div>

        <div class="header">
            <h2>Alunos</h2>
        </div>
        <div class="container">
            <?php
            foreach ($alunos as $aluno) {
                echo "<div class='card'>
                        <div class='profile-pic'><img src='../img/profile-pic-D.png' class='foto-card'></div>
                        <div class='profile-name'>$aluno</div>
                      </div>";
            }
            ?>
        </div>
    </div>
</main>
<script src="../js/script.js"></script>
</body>
</html>
