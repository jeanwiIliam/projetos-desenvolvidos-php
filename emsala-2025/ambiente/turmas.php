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
    $idEscola = $_GET['id'];

    $result = $conn->query("SELECT * FROM ambiente WHERE AMB_id = $idEscola");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nomeEscola = $row['AMB_nome'];
    }
}

$resultPr = $conn->query("SELECT * FROM professor WHERE PRO_AMB_ID = $idEscola");


$resTur = $conn->query("SELECT * FROM turma where TUR_AMB_id = $idEscola");
$divs = [];
if ($resTur->num_rows > 0) {
    while ($row = $resTur->fetch_assoc()) {
        $divs[] = ['id' => $row['TUR_id'], 'nome' => $row['TUR_nome']];
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                    <a href="../painel.php"><li class="side_active">Painel</li></a>
                    <a href="../pesquisar.php"><li>Pesquisar</li></a>
                    <a href="../configurações.php"><li>Configurações</li></a>
                    <a href="../php/logout.php"><li>Sair</li></a>
                </ul>
            </nav>
        </div>
        <div class="content">
            <?php echo "<h1 class='titulo1'>$nomeEscola</h1>" ?>
            <div class="panel_navs">
                <a href="turmas.php?id=<?=$idEscola?>" class="active-link">Turmas</a>
                <a href="professores.php?id=<?=$idEscola?>">Professores</a>
            </div>
            <div class="header">
                <h2 class="titulo2">Turmas cadastradas</h2>
                <button id="addDiv" class="addbutton button">Adicionar</button>
            </div>
            <div class="container">
                <?php
                foreach ($divs as $div) {
                    $idTurma = $div['id']; 
                    $nomeTurma = $div['nome']; 
                    echo "<a href='turmas-cadastros.php?id=$idTurma'><div class='filha'>$nomeTurma</div></a>";
                }
                ?>
            </div>
        </div>

        <div id="overlay" class="overlay">
            <div class="form-container form-container-user">
                <button class="close" id="closeOverlay">X</button>
                <div class="form-title">CADASTRAR TURMA</div>
                <form class="form-cadastro-user form-overlay" action="../php/cadastrarTurma.php?id=<?php echo "$idEscola" ?>" method="POST">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required>
                    <button type="submit" class="button">Salvar</button>
                </form>
            </div>
        </div>

    </main>

    <script src="../js/script.js"></script>
</body>
</html>