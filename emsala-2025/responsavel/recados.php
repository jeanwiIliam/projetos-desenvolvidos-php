<?php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

$res_id = $_SESSION['id'];

$nome_completo = $_SESSION['user'];
$nome = explode(' ', $nome_completo)[0];

include '../php/db.php';

$alu_id = isset($_GET['ida']) ? intval($_GET['ida']) : 0;
$nomeAluno = '';
if ($alu_id > 0) {
    $sql = "SELECT ALU_nome FROM aluno WHERE ALU_id = $alu_id";
    $res = $conn->query($sql);
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $nomeAluno = $row['ALU_nome'];
    }
}

if (isset($_GET['id']) && isset($_GET['disc'])) {
    $idTurma = intval($_GET['id']);
    $disciplinaSelecionada = urldecode($_GET['disc']);

    $result = $conn->query("SELECT * FROM turma WHERE TUR_id = $idTurma");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nomeTurma = $row['TUR_nome'];
        $idAmbiente = $row['TUR_AMB_id'];
    }

    $resDisciplina = $conn->query("SELECT TPD_id, TPD_DIS_id, TPD_DIS_tipo FROM turma_professor_disciplina WHERE TPD_TUR_id = $idTurma");
    $nomeDisciplina = '';
    $tpd_id = 0;

    if ($resDisciplina->num_rows > 0) {
        while ($disciplina = $resDisciplina->fetch_assoc()) {
            $idDis = $disciplina['TPD_DIS_id'];
            $tipo = $disciplina['TPD_DIS_tipo'];
            $nomeAtual = '';

            if ($tipo === 'predefinida') {
                $res = $conn->query("SELECT DPR_nome FROM disciplinas_predefinidas WHERE DPR_id = $idDis");
                if ($res->num_rows > 0) {
                    $nomeAtual = $res->fetch_assoc()['DPR_nome'];
                }
            } else {
                $res = $conn->query("SELECT DPE_nome FROM disciplinas_personalizadas WHERE DPE_id = $idDis");
                if ($res->num_rows > 0) {
                    $nomeAtual = $res->fetch_assoc()['DPE_nome'];
                }
            }

            if ($nomeAtual === $disciplinaSelecionada) {
                $nomeDisciplina = $nomeAtual;
                $tpd_id = $disciplina['TPD_id'];
                break;
            }
        }
    }

    $sqlGerais = "SELECT * FROM recado WHERE REC_TPD_id = $tpd_id AND REC_ALU_id IS NULL ORDER BY REC_data_envio DESC";
    $resGerais = $conn->query($sqlGerais);

    $sqlIndividuais = "SELECT * FROM recado WHERE REC_TPD_id = $tpd_id AND REC_ALU_id = $alu_id ORDER BY REC_data_envio DESC";
    $resIndividuais = $conn->query($sqlIndividuais);
}

function getAnexos($conn, $recadoId) {
    $anexos = [];
    $sql = "SELECT * FROM recado_anexo WHERE RAN_REC_id = $recadoId";
    $res = $conn->query($sql);
    if ($res && $res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $anexos[] = $row;
        }
    }
    return $anexos;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recados</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .secao-recados { display: none; }
        .secao-recados.ativa { display: block; }
    </style>
</head>
<body>
    <main>
        <div class="sidebar" id="sidebar">
            <button id="menuToggle"><span id="menuIcon">&#9664;</span></button>
            <div class="sidebar_logo"><i class="fa-solid fa-chalkboard-user"id="nav_logo"> Em Sala</i></div>
            <div class="profile">
                <img src="../img/profile-pic-L.png" alt="Foto de perfil do aluno" class="foto-sidebar">
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
            <?php echo "<h1 class='titulo1'>$nomeAluno</h1><h2 class='titulo2'>$nomeTurma - $nomeDisciplina</h2>"; ?>
            <div class="panel_navs">
                <a href="turma.php?id=<?= $idTurma ?>&disc=<?= urlencode($nomeDisciplina) ?>">Turma</a>
                <a href="recados.php?id=<?= $idTurma ?>&disc=<?= urlencode($nomeDisciplina) ?>" class="active-link">Recados</a>
            </div>

            <div class="container container-recados">
                <div class="recado-menu">
                    <button class="active" onclick="mostrarSecao('gerais')">Gerais</button>
                    <button onclick="mostrarSecao('individuais')">Individuais</button>
                </div>

                <div class="secao-recados recado-section" id="gerais" style="display: block;">
                    <div class="recado-list">
                        <?php
                        if ($resGerais->num_rows > 0) {
                            while ($recado = $resGerais->fetch_assoc()) {
                                $anexos = getAnexos($conn, $recado['REC_id']);
                                echo "<div class='recado-card'>";
                                echo "<div class='anexo-data-envio'><strong>Enviado em:</strong> " . date('d/m/Y \à\s H:i', strtotime($recado['REC_data_envio'])) . "</div>";
                                echo "{$recado['REC_texto']}<br><br>";
                                if (count($anexos) > 0) {
                                    echo "<div class='anexos'>";
                                    foreach ($anexos as $anexo) {
                                        $urlAnexo = htmlspecialchars($anexo['RAN_arquivo']);
                                        $nomeArquivo = basename($anexo['RAN_arquivo']);
                                        $partes = explode('_', $nomeArquivo, 2);
                                        $nomeExibido = $partes[1] ?? $nomeArquivo;
                                        echo "<a href='$urlAnexo' target='_blank' class='link-anexo'><i class='fa fa-paperclip'></i> $nomeExibido</a><br>";
                                    }
                                    echo "</div>";
                                }
                                echo "</div>";
                            }
                        } else {
                            echo "<p>Não há recados gerais.</p>";
                        }
                        ?>
                    </div>
                </div>

                <div class="secao-recados recado-section" id="individuais" style="display: none;">
                    <div class="recado-list">
                        <?php
                        if ($resIndividuais->num_rows > 0) {
                            while ($recado = $resIndividuais->fetch_assoc()) {
                                $anexos = getAnexos($conn, $recado['REC_id']);
                                echo "<div class='recado-card'>";
                                echo "<div class='anexo-data-envio'><strong>Enviado em:</strong> " . date('d/m/Y \à\s H:i', strtotime($recado['REC_data_envio'])) . "</div>";
                                echo "{$recado['REC_texto']}<br><br>";
                                if (count($anexos) > 0) {
                                    echo "<div class='anexos'>";
                                    foreach ($anexos as $anexo) {
                                        $urlAnexo = htmlspecialchars($anexo['RAN_arquivo']);
                                        $nomeArquivo = basename($anexo['RAN_arquivo']);
                                        $partes = explode('_', $nomeArquivo, 2);
                                        $nomeExibido = $partes[1] ?? $nomeArquivo;
                                        echo "<a href='$urlAnexo' target='_blank' class='link-anexo'><i class='fa fa-paperclip'></i> $nomeExibido</a><br>";
                                    }
                                    echo "</div>";
                                }
                                echo "</div>";
                            }
                        } else {
                            echo "<p>Não há recados individuais.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

<script>
function mostrarSecao(secao) {
    const botoes = document.querySelectorAll('.recado-menu button');
    botoes.forEach(btn => btn.classList.remove('active'));

    const secoes = document.querySelectorAll('.secao-recados');
    secoes.forEach(sec => sec.style.display = 'none');

    document.getElementById(secao).style.display = 'block';

    const botaoAtivo = Array.from(botoes).find(btn => btn.textContent.toLowerCase() === secao);
    if (botaoAtivo) botaoAtivo.classList.add('active');
}

const menuToggle = document.getElementById("menuToggle");
const sidebar = document.querySelector(".sidebar");
const icon = document.getElementById("menuIcon");

if (menuToggle && sidebar && icon) {
    menuToggle.addEventListener("click", function () {
        sidebar.classList.toggle("collapsed");
        this.style.left = sidebar.classList.contains("collapsed") ? "0px" : "250px";
        icon.innerHTML = sidebar.classList.contains("collapsed") ? "&#9654;" : "&#9664;";
    });
} else {
    console.warn("Elementos do menu lateral não encontrados.");
}
</script>

</body>
</html>
