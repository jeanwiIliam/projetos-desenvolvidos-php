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

    $resultTur = $conn->query("SELECT * FROM turma WHERE TUR_id = $idTurma");
    if ($resultTur->num_rows > 0) {
        $row = $resultTur->fetch_assoc();
        $nomeTurma = $row['TUR_nome'];
        $idEscola = $row['TUR_AMB_id'];
    }
}

$resultEsc = $conn->query("SELECT * FROM ambiente WHERE AMB_id = $idEscola");
if ($resultEsc->num_rows > 0) {
    $row = $resultEsc->fetch_assoc();
    $nomeEscola = $row['AMB_nome'];
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
            <?php echo "<h2 class='titulo2'>$nomeTurma</h2>" ?>
            <div class="panel_navs">
            <a href="turmas-cadastros.php?id=<?=$idTurma?>" class="active-link">Cadastrar</a>
            <a href="dadosTurma.php?id=<?=$idTurma?>">Registros</a>
            </div>

            <div class="header">
                <h2>Professores | Disciplinas</h2>
            </div>

            <div class="container container-pf">
                <form action="../php/cadastrarProfessorDisciplina.php" method="POST">
                    <input type="hidden" name="idEscola" value="<?php echo $idEscola; ?>">
                    <input type="hidden" name="idTurma" value="<?php echo $idTurma; ?>">

                    <table class="table-pf" border="0">
                        <tbody id="professoresDisciplinasTable">
                            <tr class="rowEntry">
                                <td>
                                    <select name="professor[]" class="professorSelect" required>
                                        <option value="">Selecione um professor</option>
                                        <?php
                                        $resultProfessores = $conn->query("SELECT PRO_id, PRO_nome FROM professor WHERE PRO_AMB_ID = $idEscola");
                                        while ($professor = $resultProfessores->fetch_assoc()) {
                                            echo "<option value='{$professor['PRO_id']}'>" . htmlspecialchars($professor['PRO_nome']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="disciplina[]" class="disciplinaSelect" onchange="checkDisciplina(this)" required>
                                        <option value="">Selecione uma disciplina</option>
                                        <?php
                                        $resultDisciplinas = $conn->query("SELECT DPR_id, DPR_nome FROM disciplinas_predefinidas");
                                        while ($disciplina = $resultDisciplinas->fetch_assoc()) {
                                            echo "<option value='{$disciplina['DPR_id']}'>" . htmlspecialchars($disciplina['DPR_nome']) . "</option>";
                                        }
                                        ?>
                                        <option value="adicionar">Adicionar disciplina</option>
                                    </select>
                                    <input type="text" name="nova_disciplina[]" class="novaDisciplinaInput" style="display:none;" placeholder="Nova disciplina">
                                </td>
                                <td><button type="button" class="removeRow btn-rmv rmv"><i class="fas fa-trash"></i></button></td>
                            </tr>
                        </tbody>
                    </table>

                    <button type="button" id="addRow" class="btn-table button">Adicionar Linha</button>
                    <button type="submit" class="btn-table button">Salvar</button>
                </form>
            </div>
            <br>


            <div class="header">
                <h2 >Alunos | Responsáveis</h2>
            </div> 
            <div class="container container-al">
                <form action="../php/cadastrarAlunosResponsaveis.php" method="POST">
                    <input type="hidden" name="idEscola" value="<?php echo $idEscola; ?>">
                    <input type="hidden" name="idTurma" value="<?php echo $idTurma; ?>">

                    <table class="table-al" border="0">

                        <tbody id="alunosResponsaveisTable">
                            <tr class="alunoRow">
                                <td>
                                    <div class="campoBloco">
                                        <input type="text" name="aluno_nome[]" placeholder="Nome do aluno" required>
                                        <input type="email" name="aluno_email[]" placeholder="Email do aluno" required>
                                    </div>
                                </td>
                                <td>
                                    <div class="campoBloco">
                                        <input type="text" name="resp_nome[]" placeholder="Nome do responsável" required>
                                        <input type="email" name="resp_email[]" placeholder="Email do responsável" required>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="removeRowAluno btn-rmv rmv"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <button type="button" id="addAlunoRow" class="btn-table button">Adicionar Linha</button>
                    <button type="submit" class="btn-table button">Salvar</button>
                </form>
            </div>

        </div>

        <div id="overlay" class="overlay">
            <div class="form-container form-container-user">
                <button class="close" id="closeOverlay">X</button>
                <div class="form-title">CADASTRAR PROFESSOR</div>
                <form class="form-cadastro-user" action="../php/cadastrarProfessor.php?id=<?php echo "$idEscola" ?>" method="POST">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required>
                    <label for="nome">Email:</label>
                    <input type="email" id="email" name="email" required>
                    <button type="submit">Salvar</button>
                </form>
            </div>
        </div>

        <div id="overlayEdit" class="overlay">
            <div class="form-container form-container-user">
                <button class="close" id="closeOverlayEdit">X</button>
                <div class="form-title">EDITAR PROFESSOR</div>
                <form class="form-cadastro-user" action="../php/editarProfessor.php?id=<?php echo "$idEscola" ?>" method="POST" id="formEdit">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nomeEdit" name="nome" required>
                    <label for="nome">Email:</label>
                    <input type="email" id="emailEdit" name="email" required>
                    <button type="submit">Salvar</button>
                </form>
            </div>
        </div>
    </main>


    <script src="../js/script.js"></script>
</body>
</html>