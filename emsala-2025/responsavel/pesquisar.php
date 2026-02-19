<?php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

$nome_completo = $_SESSION['user'];
$responsavelID = $_SESSION['id'];
$nome = explode(' ', $nome_completo)[0];

include '../php/db.php';

$filhos = [];
$turmasFilhos = [];
$resFilhos = $conn->query("SELECT ALR_ALU_id FROM aluno_responsavel WHERE ALR_RES_id = $responsavelID");
if ($resFilhos && $resFilhos->num_rows > 0) {
    while ($row = $resFilhos->fetch_assoc()) {
        $filhos[] = $row['ALR_ALU_id'];
    }

    $idsFilhosStr = implode(',', $filhos);
    $resTurmas = $conn->query("SELECT DISTINCT ALU_TUR_id FROM aluno WHERE ALU_id IN ($idsFilhosStr)");
    if ($resTurmas) {
        while ($row = $resTurmas->fetch_assoc()) {
            $turmasFilhos[] = $row['ALU_TUR_id'];
        }
    }
} else {
    echo "<p style='color:red;'>Erro ao localizar os filhos do responsável.</p>";
    exit();
}

$turmasFilhosStr = implode(',', $turmasFilhos);
$idsFilhosStr = implode(',', $filhos);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pesquisar</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .header-result {
            margin-top: 20px;
            color: #d97706;
            border-bottom: 2px solid #d97706;
        }
        .search-bar {
            display: flex;
            align-items: center;
            width: 100%;
        }
        .search-bar input[type="text"] {
            flex: 1;
            padding: 0.5rem 2.5rem 0.5rem 0.5rem;
            border: 1px solid #43407F;
            border-radius: 6px;
            position: relative;
            margin: 0 0 0 20px;
        }
        .search-bar .fa-search {
            position: relative;
            left: -55px;
            cursor: pointer;
            color: #666;
        }
        .search-bar select {
            padding: 0.5rem;
            border-radius: 6px;
            border: 1px solid #43407F;
        }
    </style>
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
                <a href="painel.php"><li>Painel</li></a>
                <a href="pesquisar.php"><li class="side_active">Pesquisar</li></a>
                <a href="configurações.php"><li>Configurações</li></a>
                <a href="../php/logout.php"><li>Sair</li></a>
            </ul>
        </nav>
    </div>

    <div class="content">
        <div class="header">
            <h1>Pesquisar</h1>
            <form method="GET" class="search-bar">
                <input type="text" name="nome" placeholder="Digite o nome..." value="<?php echo $_GET['nome'] ?? ''; ?>">
                <i class="fas fa-search" onclick="this.closest('form').submit()"></i>
                <select name="tipo">
                    <option value="todos" <?php if(($_GET['tipo'] ?? '') == 'todos') echo 'selected'; ?>>Todos</option>
                    <option value="professores" <?php if(($_GET['tipo'] ?? '') == 'professores') echo 'selected'; ?>>Professores</option>
                    <option value="alunos" <?php if(($_GET['tipo'] ?? '') == 'alunos') echo 'selected'; ?>>Alunos</option>
                </select>
            </form>
        </div>

        <?php
        $nomePesq = $_GET['nome'] ?? '';
        $tipo = $_GET['tipo'] ?? 'todos';

        if ($nomePesq !== '') {
            $nomePesq = $conn->real_escape_string($nomePesq);
            $resultPesquisa = false;

            if (($tipo == 'todos' || $tipo == 'professores') && !empty($turmasFilhosStr)) {
                $res = $conn->query("
                    SELECT p.PRO_nome, 
                           CASE tpd.TPD_DIS_tipo
                                WHEN 'predefinida' THEN dpr.DPR_nome
                                WHEN 'personalizada' THEN dpe.DPE_nome
                                ELSE 'Desconhecida'
                           END AS nome_disciplina
                    FROM turma_professor_disciplina tpd
                    JOIN professor p ON p.PRO_id = tpd.TPD_PRO_id
                    LEFT JOIN disciplinas_predefinidas dpr ON dpr.DPR_id = tpd.TPD_DIS_id AND tpd.TPD_DIS_tipo = 'predefinida'
                    LEFT JOIN disciplinas_personalizadas dpe ON dpe.DPE_id = tpd.TPD_DIS_id AND tpd.TPD_DIS_tipo = 'personalizada'
                    WHERE tpd.TPD_TUR_id IN ($turmasFilhosStr) AND p.PRO_nome LIKE '%$nomePesq%'
                ");
                if ($res->num_rows > 0) {
                    $resultPesquisa = true;
                    echo "<div class='header header-result'><h2>Professores</h2></div><div class='container'>";
                    while ($row = $res->fetch_assoc()) {
                        echo "<div class='card'>
                                <div class='profile-pic'>
                                    <img src='../img/profile-pic-D.png' alt='Foto de perfil do professor' class='foto-card'>
                                </div>
                                <div class='profile-name'>" . htmlspecialchars($row['PRO_nome']) . "<br><small>" . htmlspecialchars($row['nome_disciplina']) . "</small></div>
                              </div>";
                    }
                    echo "</div>";
                }
            }

            if (($tipo == 'todos' || $tipo == 'alunos') && !empty($idsFilhosStr)) {
                $res = $conn->query("
                    SELECT * FROM aluno 
                    WHERE ALU_id IN ($idsFilhosStr) AND ALU_nome LIKE '%$nomePesq%'
                ");
                if ($res->num_rows > 0) {
                    $resultPesquisa = true;
                    echo "<div class='header header-result'><h2>Alunos</h2></div><div class='container'>";
                    while ($row = $res->fetch_assoc()) {
                        echo "<div class='card'>
                                <div class='profile-pic'>
                                    <img src='../img/profile-pic-D.png' alt='Foto de perfil do aluno' class='foto-card'>
                                </div>
                                <div class='profile-name'>" . htmlspecialchars($row['ALU_nome']) . "</div>
                              </div>";
                    }
                    echo "</div>";
                }
            }

            if (!$resultPesquisa) {
                echo "<div class='container'>";
                echo "<p style='margin-top:20px; width:500px; color: #af1818; font-weight: bold;'>Nenhum resultado encontrado.</p>";
                echo "</div>";
            }
        }
        ?>
    </div>
</main>
<script src="../js/script.js"></script>
</body>
</html>
