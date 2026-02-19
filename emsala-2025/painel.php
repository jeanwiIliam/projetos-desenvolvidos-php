<?php

session_start();

if (!isset($_SESSION['user']) and !isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$nome_completo = $_SESSION['user'];
$admID = $_SESSION['id'];
$nome = explode(' ', $nome_completo)[0];

include 'php/db.php';

$result = $conn->query("SELECT * FROM ambiente WHERE AMB_ADM_id = $admID");
$divs = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $divs[] = ['id' => $row['AMB_id'], 'nome' => $row['AMB_nome']];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
    <main>
        <div class="sidebar" id="sidebar">
            <button id="menuToggle"><span id="menuIcon">&#9664;</span></button>
            <div class="sidebar_logo"><i class="fa-solid fa-chalkboard-user"id="nav_logo"> Em Sala</i></div>
            <div class="profile">
                <img src="img/profile-pic-L.png" alt="Foto de perfil do professor" class="foto-sidebar">
                <?php echo "<p>Bem-vindo</br>".$nome."</p>"?>  
            </div>
            <nav class="sidebar_nav">
                <ul class="sidebar_nav_links">
                    <a href="painel.php"><li class="side_active">Painel</li></a>
                    <a href="pesquisar.php"><li>Pesquisar</li></a>
                    <a href="configurações.php"><li>Configurações</li></a>
                    <a href="php/logout.php"><li>Sair</li></a>
                </ul>
            </nav>
        </div>
        <div class="content">
            <div class="header">
                <h1>Ambientes cadastrados</h1>
                <button id="addDiv" class="addbutton button">Adicionar</button>
            </div>
            <div class="container">
                <?php
                foreach ($divs as $div) {
                    $idEscola = $div['id'];
                    $nomeEscola = $div['nome'];
                    echo "<a href='ambiente/turmas.php?id=$idEscola'><div class='filha'>$nomeEscola</div></a>";
                }
                ?>
            </div>
        </div>

        <div id="overlay" class="overlay">
            <div class="form-container">
                <button class="close" id="closeOverlay">X</button>
                <div class="form-title">ADICIONAR AMBIENTE</div>
                <p>Aqui você irá cadastrar o nome do ambiente virtual o qual irá administrar. Nele você irá adicionar todas as turmas necessárias.</p>
                <p class="obs">Recomenda-se que seja o nome da escola, para facilitar sua identificação</p>
                <form action="php/cadastrarAmbiente.php" method="POST" class="form-overlay">
                    <label for="nome">Nome do ambiente:</label>
                    <input type="text" id="nome" name="nome" required>
                    <button type="submit" class="button">Salvar</button>
                </form>
            </div>
        </div>
    </main>

    <script src="js/script.js"></script>
</body>
</html>