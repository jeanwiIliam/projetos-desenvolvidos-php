<?php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['id']) || $_SESSION['tipo'] !== 'responsavel') {
    header("Location: ../login.php");
    exit();
}

$nome_completo = $_SESSION['user'];
$responsavelID = $_SESSION['id'];
$nome = explode(' ', $nome_completo)[0];

include '../php/db.php';

$queryAlunos = "SELECT a.ALU_id, a.ALU_nome, t.TUR_nome
                FROM aluno_responsavel ar
                JOIN aluno a ON ar.ALR_ALU_id = a.ALU_id
                JOIN turma t ON a.ALU_TUR_id = t.TUR_id
                WHERE ar.ALR_RES_id = ?";

$stmt = $conn->prepare($queryAlunos);
$stmt->bind_param("i", $responsavelID);
$stmt->execute();
$result = $stmt->get_result();

$alunos = [];
while ($row = $result->fetch_assoc()) {
    $alunos[] = $row;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Responsável</title>
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
            <h1>Alunos</h1>
        </div>
        <div class="container">
            <?php
            if (!empty($alunos)) {
                foreach ($alunos as $aluno) {
                    $nomeAluno = htmlspecialchars($aluno['ALU_nome']);
                    $turma = htmlspecialchars($aluno['TUR_nome']);
                    echo "<a href='aluno.php?id={$aluno['ALU_id']}'><div class='filha'>$nomeAluno<br><small style='margin-top: 15px;'>$turma</small></div></a>";
                }
            } else {
                echo "<p>Nenhum aluno vinculado a este responsável.</p>";
            }
            ?>
        </div>
    </div>
</main>

<script src="../js/script.js"></script>
</body>
</html>
