<?php

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$nome_completo = $_SESSION['user'];
$nome = explode(' ', $nome_completo)[0];

include '../php/db.php';

if (isset($_GET['id'])) {
    $idTurma = $_GET['id'];

    $result = $conn->query("SELECT * FROM turma WHERE TUR_id = $idTurma");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nomeTurma = $row['TUR_nome'];
        $idAmbiente = $row['TUR_AMB_id'];
    }


$professorId = $_SESSION['id'];

$resDisciplina = $conn->query("
    SELECT TPD_DIS_id, TPD_DIS_tipo 
    FROM turma_professor_disciplina 
    WHERE TPD_TUR_id = $idTurma 
    AND TPD_PRO_id = $professorId 
    LIMIT 1
");

    $nomeDisciplina = '';
    if ($resDisciplina->num_rows > 0) {
        $disciplina = $resDisciplina->fetch_assoc();
        $idDis = $disciplina['TPD_DIS_id'];
        $tipo = $disciplina['TPD_DIS_tipo'];

        if ($tipo === 'predefinida') {
            $res = $conn->query("SELECT DPR_nome FROM disciplinas_predefinidas WHERE DPR_id = $idDis");
            if ($res->num_rows > 0) {
                $nomeDisciplina = $res->fetch_assoc()['DPR_nome'];
            }
        } else {
            $res = $conn->query("SELECT DPE_nome FROM disciplinas_personalizadas WHERE DPE_id = $idDis");
            if ($res->num_rows > 0) {
                $nomeDisciplina = $res->fetch_assoc()['DPE_nome'];
            }
        }
    }
}
/*
$alunos = [];
$resAlunos = $conn->query("SELECT * FROM aluno WHERE ALU_TUR_id = $idTurma");
if ($resAlunos->num_rows > 0) {
    while ($row = $resAlunos->fetch_assoc()) {
        $alunos[] = $row['ALU_nome'];
    }
}
*/

$resAlunos = $conn->query("SELECT ALU_id, ALU_nome FROM aluno WHERE ALU_TUR_id = $idTurma");

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel da Turma</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .aluno-card {
            position: relative;
            overflow: hidden;
        }

        .aluno-card .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.85);
            color: white;
            font-weight: bold;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            cursor: pointer;
            z-index: 10;
        }

        .aluno-card:hover .overlay {
            opacity: 1;
        }

    </style>

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
            <?php echo "<h1 class='titulo1'>$nomeTurma</h1>
                        <h2 class='titulo2'>$nomeDisciplina</h2>" ?>
            <div class="panel_navs">
                <a href="alunos.php?id=<?=$idTurma?>" class="active-link">Alunos</a>
                <a href="recados.php?id=<?=$idTurma?>">Recados</a>
            </div>
            <div class="header">
                <h2>Alunos</h2>
            </div>
            <div class="container">
                <?php
                    foreach ($resAlunos as $aluno) {
                        $idAluno = $aluno['ALU_id'];
                        $nomeAluno = $aluno['ALU_nome'];

                        echo "
                        <div class='card aluno-card' data-id='$idAluno'>
                            <div class='overlay' onclick='abrirChat($idAluno)'>Falar com responsável</div>
                            <div class='profile-pic'>
                                <img src='../img/profile-pic-D.png' alt='Foto de perfil do aluno' class='foto-card'>
                            </div>
                            <div class='profile-name'>$nomeAluno</div>
                        </div>";
                    }
                ?>
            </div>
        </div>
    </main>

    <script> 
        function abrirChat(idAluno) {
            window.open(`../chat.php?stdid=${idAluno}`, '_blank');
        }
    </script>



    <script src="../js/script.js"></script>
</body>
</html>
