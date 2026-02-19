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
                <a href="turmas.php?id=<?=$idEscola?>">Turmas</a>
                <a href="professores.php?id=<?=$idEscola?>" class="active-link">Professores</a>
            </div>
            <div class="header">
                <h2>Professores cadastrados</h2>
                <button id="addDiv" class="addbutton button">Adicionar</button>
            </div>
            <div class="container container-pf">

                <table class="table-pf" border="0">
                    <tbody id="professoresTable">
                        <?php while ($row = $resultPr->fetch_assoc()): ?>
                            <tr data-id="<?= htmlspecialchars($row['PRO_id']); ?>" >
                                <td><?= htmlspecialchars($row['PRO_nome']); ?></td>
                                <td><?= htmlspecialchars($row['PRO_email']); ?></td>
                                <td><button class="edt" onclick="openEditForm(this)" title="Editar professor">✏️</button></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>


            </div>
        </div>

        <div id="overlay" class="overlay">
            <div class="form-container form-container-user">
                <button class="close" id="closeOverlay">X</button>
                <div class="form-title">CADASTRAR PROFESSOR</div>
                <form class="form-cadastro-user form-overlay" action="../php/cadastrarProfessor.php?id=<?php echo "$idEscola" ?>" method="POST">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required>
                    <label for="nome">Email:</label>
                    <input type="email" id="email" name="email" required>
                    <button type="submit" class="button">Salvar</button>
                </form>
            </div>
        </div>

        <div id="overlayEdit" class="overlay">
            <div class="form-container form-container-user">
                <button class="close" id="closeOverlayEdit">X</button>
                <div class="form-title">EDITAR PROFESSOR</div>
                <form class="form-cadastro-user form-overlay" action="../php/editarProfessor.php?id=<?php echo "$idEscola" ?>" method="POST" id="formEdit">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nomeEdit" name="nome" required>
                    <label for="nome">Email:</label>
                    <input type="email" id="emailEdit" name="email" required>
                    <button type="submit" class="button">Salvar</button>
                </form>
            </div>
        </div>
    </main>

    <script src="../js/script.js"></script>
</body>
</html>