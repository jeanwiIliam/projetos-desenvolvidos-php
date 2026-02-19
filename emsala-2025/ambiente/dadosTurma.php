<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

include '../php/db.php';

$idTurma = $_GET['id'] ?? null;
if (!$idTurma) {
    echo "Turma não informada.";
    exit();
}

$nome_completo = $_SESSION['user'];
$nome = explode(' ', $nome_completo)[0];

$turmaNome = "";
$idEscola = null;

$stmt = $conn->prepare("SELECT TUR_nome, TUR_AMB_id FROM turma WHERE TUR_id = ?");
$stmt->bind_param("i", $idTurma);
$stmt->execute();
$stmt->bind_result($turmaNome, $idEscola);
$stmt->fetch();
$stmt->close();

if (!$idEscola) {
    echo "Turma não encontrada.";
    exit();
}

$escolaNome = "";
$stmt = $conn->prepare("SELECT AMB_nome FROM ambiente WHERE AMB_id = ?");
$stmt->bind_param("i", $idEscola);
$stmt->execute();
$stmt->bind_result($escolaNome);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resumo da Turma</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100vw; height: 100vh;
            background: rgba(0,0,0,0.6);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .overlay-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        .btn-delete {
            background-color: red;
            color: white;
            border: none;
            padding: 6px 12px;
            cursor: pointer;
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
                <a href="../painel.php"><li class="side_active">Painel</li></a>
                <a href="../pesquisar.php"><li>Pesquisar</li></a>
                <a href="../configurações.php"><li>Configurações</li></a>
                <a href="../php/logout.php"><li>Sair</li></a>
            </ul>
        </nav>
    </div>

    <div class="content">
        <h1 class="titulo1"><?= $escolaNome ?></h1>
        <h2 class="titulo2"><?= $turmaNome ?></h2>

        <div class="panel_navs">
            <a href="turmas-cadastros.php?id=<?= $idTurma ?>">Cadastrar</a>
            <a href="dadosTurma.php?id=<?= $idTurma ?>" class="active-link">Registros</a>
        </div>

        <div class="header">
            <h2>Professores Vinculados</h2>
        </div>
        <div class="container container-reg">
            <table class="table-reg" border="0" id="tabelaProfessores">
                <thead>
                    <tr>
                        <th>Professor</th>
                        <th>Disciplina</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT PRO.PRO_nome, TPD.TPD_id, TPD.TPD_DIS_id, TPD.TPD_DIS_tipo
                        FROM turma_professor_disciplina TPD
                        INNER JOIN professor PRO ON PRO.PRO_id = TPD.TPD_PRO_id
                        WHERE TPD.TPD_TUR_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $idTurma);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    $nomeDisciplina = "";

                    if ($row['TPD_DIS_tipo'] === 'predefinida') {
                        $stmtDisc = $conn->prepare("SELECT DPR_nome FROM disciplinas_predefinidas WHERE DPR_id = ?");
                    } else {
                        $stmtDisc = $conn->prepare("SELECT DPE_nome FROM disciplinas_personalizadas WHERE DPE_id = ?");
                    }

                    $stmtDisc->bind_param("i", $row['TPD_DIS_id']);
                    $stmtDisc->execute();
                    $stmtDisc->bind_result($nomeDisciplina);
                    $stmtDisc->fetch();
                    $stmtDisc->close();

                    echo "<tr data-id='{$row['TPD_id']}'>
                            <td>{$row['PRO_nome']}</td>
                            <td>{$nomeDisciplina}</td>
                            <td><button class='btn-rmv rmv' onclick='confirmarExclusao({$row['TPD_id']})'><i class='fas fa-trash'></i></button></td>
                          </tr>";
                }
                $stmt->close();
                ?>
                </tbody>
            </table>
        </div>
        <br>


        <div class="header">
            <h2>Alunos | Responsáveis</h2>
        </div>
        <div class="container container-reg">
            <table class="table-reg" border="0" id="tabelaRegistros">
                <thead>
                    <tr>
                        <th>Aluno</th>
                        <th>Email</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT 
                            ALU.ALU_id, ALU.ALU_nome, ALU.ALU_email, 
                            RES.RES_id, RES.RES_nome, RES.RES_email
                        FROM aluno ALU
                        LEFT JOIN aluno_responsavel ALR ON ALR.ALR_ALU_id = ALU.ALU_id
                        LEFT JOIN responsavel RES ON RES.RES_id = ALR.ALR_RES_id
                        WHERE ALU.ALU_TUR_id = ?
                        ORDER BY ALU.ALU_nome, RES.RES_nome";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $idTurma);
                $stmt->execute();
                $stmt->bind_result($idAluno, $nomeAluno, $emailAluno, $idResponsavel, $nomeResponsavel, $emailResponsavel);

                while ($stmt->fetch()) {
                    echo "
                    <tr class='aluno-linha' data-id='$idAluno'>
                        <td class='td-al'>$nomeAluno</td>
                        <td class='td-al'>$emailAluno</td>
                        <td class='td-al'>
                            <button class='btn-toggle' data-id='$idAluno' title='Ver responsáveis'><i class='fas fa-eye'></i></button>
                            <button class='btn-edit'
                                data-id='$idAluno'
                                data-nome=\"$nomeAluno\"
                                data-email=\"$emailAluno\"
                                data-res-id=\"$idResponsavel\"
                                data-res-nome=\"$nomeResponsavel\"
                                data-res-email=\"$emailResponsavel\"
                                title='Editar aluno e responsável'
                                style='border:none; font-size:16px; cursor: pointer; margin: 0 3px 0 3px;'>
                                <i class='fas fa-pencil-alt'></i>
                            </button>
                            <button class='btn-delete-aluno' data-id='$idAluno' title='Excluir aluno' style='border:none; font-size:16px; cursor: pointer;'><i class='fas fa-trash'></i></button>
                        </td>
                    </tr>
                    <tr class='responsaveis-linha' id='resp-$idAluno' style='display: none;'>
                        <td colspan='3'>
                            <div class='responsaveis-container' id='container-$idAluno'>
                                <em>Carregando responsáveis...</em>
                            </div>
                        </td>
                    </tr>";
                }
                $stmt->close();

                ?>
                </tbody>
            </table>
        </div>
    </div>
</main>


<div class="overlay" id="overlay">
    <div class="overlay-box">
        <p>Tem certeza que deseja excluir esse vínculo?</p>
        <div class="options">
            <button onclick="excluirConfirmado()" class="button confirm">Sim</button>
            <button onclick="fecharOverlay()" class="button cancel">Cancelar</button>
        </div>
    </div>
</div>


<div class="overlay" id="modal-editar-aluno">
    <div class="overlay-box">
        <h3 class="modal-title modal-title-editar-aluno">Editar Registro</h3>
        <form id="form-editar-aluno" method="POST" action="../php/editarAluno.php">
            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">

            <h3 class="modal-h3">Aluno</h3>
            <input type="hidden" name="ALU_id" id="edit-alu-id">
            <label for="edit-alu-nome">Nome:</label>
            <input type="text" name="ALU_nome" id="edit-alu-nome" required><br><br>
            <label for="edit-alu-email">Email:</label>
            <input type="email" name="ALU_email" id="edit-alu-email" required><br><br>

            <h3 class="modal-h3">Responsável</h3>
            <input type="hidden" name="RES_id" id="edit-res-id">
            <label for="edit-res-nome">Nome:</label>
            <input type="text" name="RES_nome" id="edit-res-nome" required><br><br>
            <label for="edit-res-email">Email:</label>
            <input type="email" name="RES_email" id="edit-res-email" required><br><br>

            <button type="submit" class="button cancel">Salvar</button>
            <button type="button" class="button confirm" onclick="fecharModalEditar()">Cancelar</button>
        </form>
    </div>
</div>

<script>
function confirmarExclusao(id) {
    document.getElementById('overlay').style.display = 'flex';
    window.idParaExcluir = id;
}
function fecharOverlay() {
    document.getElementById('overlay').style.display = 'none';
}
function excluirConfirmado() {
    // Lógica AJAX
    fecharOverlay();
}

function fecharModalEditar() {
    document.getElementById('modal-editar-aluno').style.display = 'none';
}

document.querySelectorAll('.btn-edit').forEach(button => {
    button.addEventListener('click', () => {
        document.getElementById('edit-alu-id').value = button.dataset.id;
        document.getElementById('edit-alu-nome').value = button.dataset.nome;
        document.getElementById('edit-alu-email').value = button.dataset.email;
        document.getElementById('edit-res-id').value = button.dataset.resId;
        document.getElementById('edit-res-nome').value = button.dataset.resNome;
        document.getElementById('edit-res-email').value = button.dataset.resEmail;
        document.getElementById('modal-editar-aluno').style.display = 'flex';
    });
});
</script>



<script>
document.querySelectorAll('.btn-delete-aluno').forEach(button => {
    button.addEventListener('click', () => {
        const alunoId = button.getAttribute('data-id');

        if (confirm('Tem certeza que deseja excluir este aluno?')) {
            fetch('../php/excluirAlunosResponsaveis.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${alunoId}`
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === 'ok') {
                    // Remove as duas linhas: aluno e responsáveis
                    const linhaAluno = button.closest('tr');
                    const linhaResp = document.getElementById('resp-' + alunoId);
                    linhaAluno.remove();
                    if (linhaResp) linhaResp.remove();
                } else {
                    alert('Erro ao excluir: ' + data);
                }
            });
        }
    });
});
</script>



<script src="../js/script.js"></script>

</body>
</html>
