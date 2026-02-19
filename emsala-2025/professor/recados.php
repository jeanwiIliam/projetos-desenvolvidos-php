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

    $nomeProfessor = $_SESSION['user']; 

    $sqlVinculo = "
        SELECT tpd.TPD_id, tpd.TPD_DIS_id, tpd.TPD_DIS_tipo, t.TUR_nome, t.TUR_AMB_id
        FROM turma_professor_disciplina tpd
        JOIN turma t ON tpd.TPD_TUR_id = t.TUR_id
        JOIN professor p ON tpd.TPD_PRO_id = p.PRO_id
        WHERE t.TUR_id = $idTurma AND p.PRO_nome = '$nomeProfessor'
        LIMIT 1
    ";

    $resVinculo = $conn->query($sqlVinculo);

    if ($resVinculo->num_rows > 0) {
        $row = $resVinculo->fetch_assoc();
        $tpd_id = $row['TPD_id'];
        $idDis = $row['TPD_DIS_id'];
        $tipo = $row['TPD_DIS_tipo'];
        $nomeTurma = $row['TUR_nome'];
        $idAmbiente = $row['TUR_AMB_id'];

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
    } else {
        echo "<p style='color: red;'>Acesso não autorizado.</p>";
        exit();
    }
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
            <?php echo "<h1 class='titulo1'>$nomeTurma</h1><h2 class='titulo2'>$nomeDisciplina</h2>"; ?>
            <div class="panel_navs">
                <a href="turma.php?id=<?= $idTurma ?>">Alunos</a>
                <a href="recados.php?id=<?= $idTurma ?>" class="active-link">Recados</a>
            </div>

            <div class="container container-recados">
                <div class="recado-menu">
                    <button class="active" onclick="mostrarSecao('enviar')">Enviar</button>
                    <button onclick="mostrarSecao('programados')">Programados</button>
                    <button onclick="mostrarSecao('enviados')">Enviados</button>
                </div>

                <div id="secao-enviar" class="recado-section active">
                    <form class="recado-form" action="../php/recado-processar.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="tpd_id" value="<?= $tpd_id ?>">
                        <label for="destino">Tipo de recado</label>
                        <select name="destino" id="destino" onchange="toggleCampoAluno(this.value)">
                            <option value="geral">Geral (para todos)</option>
                            <option value="individual">Individual (para um aluno)</option>
                        </select>

                        <div id="campoAluno" style="display:none;">
                            <label for="aluno">Selecionar aluno</label>
                            <select name="aluno_id" id="aluno">
                                <?php
                                $res = $conn->query("SELECT * FROM aluno WHERE ALU_TUR_id = $idTurma");
                                while ($a = $res->fetch_assoc()) {
                                    echo "<option value='{$a['ALU_id']}'>{$a['ALU_nome']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <label for="mensagem">Mensagem</label>
                        <textarea name="mensagem" rows="4" required></textarea>

                        <div class="anexar">
                            <label class="label-anexos">Anexar arquivos (opcional)</label>
                            <button type="button" class="addAnexo" title="Adicionar anexo">+</button>
                        </div>
                        
                        <div id="anexos-container">
                            <input id="arquivo" type="file" name="arquivos[]" class="arquivo-input" style="margin-bottom: 10px;">
                        </div>
                        
                        <label for="data_envio">Data de envio (deixe vazio para enviar agora)</label>
                        <input class="datetime" type="datetime-local" name="data_envio">

                        <button type="submit" class="button">Enviar</button>
                    </form>
                </div>

                <div id="secao-programados" class="recado-section"> 
                    <div class="recado-list">
                        <?php
$res = $conn->query("
    SELECT * FROM recado 
    WHERE REC_TPD_id = $tpd_id
    AND REC_programado = 1 AND REC_data_envio > NOW()
");

                        if ($res->num_rows > 0) {
                            while ($r = $res->fetch_assoc()) {
                                $dataInput = date('Y-m-d', strtotime($r['REC_data_envio'])); 
                                $dataExibicao = date('d/m/Y', strtotime($r['REC_data_envio']));
                                $hora = date('H:i', strtotime($r['REC_data_envio']));
                                $textoLimpo = htmlspecialchars($r['REC_texto'], ENT_QUOTES, 'UTF-8');

                                echo "<div class='recado-card'>";

                                echo "<span class='icone-recado' onclick='abrirModalEdicao($r[REC_id], \"$dataInput\", \"$hora\", \"$textoLimpo\")' title='Editar recado' style='margin: 7px 45px 0 0;'><i class='fas fa-pencil-alt  btn-edit'></i></span>";

                                echo "<span class='icone-recado' onclick='abrirModalExclusaoRecado($r[REC_id])' title='Excluir recado'><i class='fas fa-trash-alt btn-rmv rmv'></i></span>";

                                echo "<div class='anexo-data-envio'><strong>Programado para:</strong> $dataExibicao às $hora</div>";

                                if (!empty($r['REC_ALU_id'])) {
                                    $alunoId = intval($r['REC_ALU_id']);
                                    $resAluno = $conn->query("SELECT ALU_nome FROM aluno WHERE ALU_id = $alunoId");
                                    if ($resAluno && $resAluno->num_rows > 0) {
                                        $aluno = $resAluno->fetch_assoc();
                                        $nomeAluno = htmlspecialchars($aluno['ALU_nome']);
                                        echo "<div class='recado-aluno'><strong>Para:</strong> $nomeAluno</div>";
                                    }
                                }

                                echo "{$r['REC_texto']}<br>";

                                $recadoId = $r['REC_id'];
                                $resAnexo = $conn->query("SELECT * FROM recado_anexo WHERE RAN_REC_id = $recadoId");

                                if ($resAnexo->num_rows > 0) {
                                    echo "<div class='anexos'><br><ul>";
                                    while ($anexo = $resAnexo->fetch_assoc()) {
                                        $caminho = htmlspecialchars($anexo['RAN_arquivo']);
                                        $nomeArquivo = preg_replace('/^[^_]*_/', '', basename($caminho));
                                        echo "<li><i class='fas fa-paperclip'></i> <a href='$caminho' target='_blank' class='link-anexo'>$nomeArquivo</a></li>";
                                    }
                                    echo "</ul></div>";
                                }

                                echo "</div>";
                            }
                        } else {
                            echo "<p>Nenhum recado programado.</p>";
                        }
                        ?>
                    </div>
                </div>


                <div id="secao-enviados" class="recado-section">
                    <div class="recado-list">
                        <?php
                        $res = $conn->query("
                            SELECT * FROM recado 
                            WHERE REC_TPD_id = $tpd_id
                            AND REC_data_envio <= NOW()
                        ");

                        if ($res->num_rows > 0) {
                            while ($r = $res->fetch_assoc()) {
                                echo "<div class='recado-card'>";

                                $dataInput = date('Y-m-d', strtotime($r['REC_data_envio'])); 
                                $data = date('d/m/Y', strtotime($r['REC_data_envio']));
                                $hora = date('H:i', strtotime($r['REC_data_envio']));
                                echo "<div class='anexo-data-envio'><strong>Enviado em:</strong> $data às $hora</div>";

                                if (!empty($r['REC_ALU_id'])) {
                                    $alunoId = intval($r['REC_ALU_id']);
                                    $resAluno = $conn->query("SELECT ALU_nome FROM aluno WHERE ALU_id = $alunoId");
                                    if ($resAluno && $resAluno->num_rows > 0) {
                                        $aluno = $resAluno->fetch_assoc();
                                        $nomeAluno = htmlspecialchars($aluno['ALU_nome']);
                                        echo "<div class='recado-aluno'><strong>Para:</strong> $nomeAluno</div>";
                                    }
                                }


                                echo "{$r['REC_texto']}<br>";
                                $textoLimpo = htmlspecialchars($r['REC_texto'], ENT_QUOTES, 'UTF-8');

                               echo "<span class='icone-recado' onclick='abrirModalExclusaoRecado($r[REC_id])' title='Excluir recado'><i class='fas fa-trash-alt btn-rmv rmv'></i></span>";

                                $recadoId = $r['REC_id'];
                                $resAnexo = $conn->query("SELECT * FROM recado_anexo WHERE RAN_REC_id = $recadoId");
                            
                                if ($resAnexo->num_rows > 0) {
                                    echo "<div class='anexos'><br><ul>";
                                    while ($anexo = $resAnexo->fetch_assoc()) {
                                        $caminho = htmlspecialchars($anexo['RAN_arquivo']);
                                        $nomeArquivo = preg_replace('/^[^_]*_/', '', basename($caminho)); 

                                        echo "<li><i class='fas fa-paperclip'></i> <a href='$caminho' target='_blank' class='link-anexo'>$nomeArquivo</a></li>";
                                    }
                                    echo "</ul></div>";
                                }
                            
                                echo "</div>";
                            }
                            
                        } else {
                            echo "<p>Nenhum recado enviado.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <div class="modal-overlay" id="modal-editar">
        <div class="modal modal-editar">
            <h3 class="modal-title">Editar Recado</h3>
            <form action="../php/recado-atualizar.php" method="POST" enctype="multipart/form-data" class="modal-form">
                <input type="hidden" name="recado_id" id="modal-recado-id">
                
                <label>Texto do recado:</label>
                <textarea name="novo_texto" id="modal-texto" rows="4" required></textarea>

                <label>Nova data:</label>
                <input type="date" name="nova_data" id="modal-data" required>

                <label>Nova hora:</label>
                <input type="time" name="nova_hora" id="modal-hora" required>

                <label>Anexos existentes:</label>
                <div id="anexos-existentes">

                </div>

                <div id="novos-anexos"></div>
                <button type="button" onclick="criarInputNovoAnexo()" class="addAnexo" title="Adicionar anexos">+</button>

                <input type="hidden" name="anexos_remover" id="anexos_remover">

                <br><br>
                <button type="submit" class="button cancel" style="margin-top: 0;">Salvar alterações</button>
                <button type="button" onclick="fecharModal()" class="button confirm" style="margin-top: 3px;">Cancelar</button>
            </form>
        </div>
    </div>


    <div id="modalConfirmacao" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.5); justify-content: center; align-items: center; z-index: 9999;" class="overlay">
        
        <div class="modal" style="background: white; padding: 20px; border-radius: 8px; width: 300px; text-align: center;">
            <p id="textoModal" style="margin-bottom: 20px;"></p>
            <button onclick="confirmarRemocaoFinal()" class="button confirm">Sim</button>
            <button onclick="cancelarRemocao()" class="button cancel">Cancelar</button>
        </div>
    </div>

    
    <div id="modalConfirmarExclusaoRecado" class="overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;">
        <div class="modal modal-conteudo" style="background: white; padding: 20px; border-radius: 8px; width: 300px; text-align: center;">
            <p id="textoConfirmarExclusao">Deseja realmente excluir este recado?</p>
            <div class="botoes-modal">
                <button onclick="confirmarExclusaoRecadoFinal()" class="button confirm">Sim</button>
                <button onclick="fecharModalExclusaoRecado()" class="button cancel">Cancelar</button>
            </div>
        </div>
    </div>


<script>
let anexoIdParaRemover = null;
let elementoAnexo = null;

function confirmarRemocaoAnexo(id, nomeArquivo, linhaElemento) {
    anexoIdParaRemover = id;
    elementoAnexo = linhaElemento;
    document.getElementById("textoModal").textContent = `Deseja remover o anexo "${nomeArquivo}"?`;
    document.getElementById("modalConfirmacao").style.display = "flex";
}

function confirmarRemocaoNovoAnexo(input, linhaTabela) {
    if (confirm('Deseja remover este novo anexo?')) {
        input.remove();       
        linhaTabela.remove(); 
    }
}

function cancelarRemocao() {
    anexoIdParaRemover = null;
    elementoAnexo = null;
    document.getElementById("modalConfirmacao").style.display = "none";
}

function confirmarRemocaoFinal() {
    if (anexoIdParaRemover && elementoAnexo) {
        elementoAnexo.remove();
        let campo = document.getElementById("anexos_remover");
        let idsAtuais = campo.value ? campo.value.split(',') : [];
        if (!idsAtuais.includes(String(anexoIdParaRemover))) {
            idsAtuais.push(anexoIdParaRemover);
        }
        campo.value = idsAtuais.join(',');
        anexoIdParaRemover = null;
        elementoAnexo = null;
    }
    document.getElementById("modalConfirmacao").style.display = "none";
}
</script>

<script>
let anexosOriginaisHTML = '';

function abrirModalEdicao(recadoId, data, hora, texto) {
    const modal = document.getElementById('modal-editar');
    const textoInput = document.getElementById('modal-texto');
    const dataInput = document.getElementById('modal-data');
    const horaInput = document.getElementById('modal-hora');
    const idInput = document.getElementById('modal-recado-id');
    const container = document.getElementById('anexos-existentes');

    idInput.value = recadoId;
    textoInput.value = texto;
    dataInput.value = data;
    horaInput.value = hora;

    modal.dataset.originalTexto = texto;
    modal.dataset.originalData = data;
    modal.dataset.originalHora = hora;

    container.innerHTML = '';
    anexosOriginaisHTML = '';

    const xhr = new XMLHttpRequest();
    xhr.open('GET', '../php/recado-anexo-buscar.php?recado_id=' + recadoId, true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const anexos = JSON.parse(xhr.responseText);
            if (anexos.length > 0) {
                const tabela = document.createElement('table');
                tabela.classList.add('tabela-anexos');
                anexos.forEach(anexo => {
                    const linha = tabela.insertRow();

                    const celulaArquivo = linha.insertCell();
                    const link = document.createElement('a');
                    link.href = anexo.caminho;
                    link.target = '_blank';
                    link.textContent = anexo.nome;
                    celulaArquivo.appendChild(link);

                    const celulaExcluir = linha.insertCell();
                    const botao = document.createElement('button');
                    botao.type = 'button';
                    botao.classList.add('btn-remover-anexo');
                    botao.innerHTML = '<i class="fas fa-trash-alt btn-rmv rmv"></i>';
                    botao.onclick = function () {
                        confirmarRemocaoAnexo(anexo.id, anexo.nome, linha);
                    };
                    celulaExcluir.appendChild(botao);
                    celulaExcluir.style.textAlign = 'center';
                });

                container.appendChild(tabela);
                anexosOriginaisHTML = container.innerHTML;
            } else {
                container.innerHTML = '<p>Nenhum anexo.</p>';
                anexosOriginaisHTML = container.innerHTML;
            }
        } else {
            container.innerHTML = '<p>Erro ao buscar anexos.</p>';
            anexosOriginaisHTML = container.innerHTML;
        }
    };
    xhr.send();

    modal.style.display = 'flex';
}

function fecharModal() {
    const modal = document.getElementById('modal-editar');
    document.getElementById('modal-texto').value = modal.dataset.originalTexto || '';
    document.getElementById('modal-data').value = modal.dataset.originalData || '';
    document.getElementById('modal-hora').value = modal.dataset.originalHora || '';
    document.getElementById('anexos-existentes').innerHTML = anexosOriginaisHTML;
    const novosAnexos = document.querySelectorAll('.input-novo-anexo');
    novosAnexos.forEach(input => input.remove());
    modal.style.display = 'none';
}
</script>

<script>
function toggleCampoAluno(valor) {
    document.getElementById('campoAluno').style.display = valor === 'individual' ? 'block' : 'none';
}
</script>


<script>

function criarInputNovoAnexo() {
    const novosAnexosContainer = document.getElementById('novos-anexos');
    const visualContainer = document.getElementById('anexos-existentes');

    const input = document.createElement('input');
    input.type = 'file';
    input.name = 'novos_anexos[]';
    input.style.display = 'none';

    input.onchange = () => {
        const file = input.files[0];
        if (file) {
            let tabela = visualContainer.querySelector('table');
            if (!tabela) {
                tabela = document.createElement('table');
                tabela.classList.add('tabela-anexos');
                visualContainer.innerHTML = '';
                visualContainer.appendChild(tabela);
            }

            const linha = tabela.insertRow();

            const celulaArquivo = linha.insertCell();
            const link = document.createElement('a');
            link.href = URL.createObjectURL(file);
            link.target = '_blank';

            let nomeArquivo = file.name.replace(/_/g, ' ');
            link.textContent = nomeArquivo; 
            celulaArquivo.appendChild(link);

            const celulaExcluir = linha.insertCell();
            const botao = document.createElement('button');
            botao.type = 'button';
            botao.classList.add('btn-remover-anexo');
            botao.innerHTML = '<i class="fas fa-trash-alt btn-rmv rmv"></i>';
            botao.onclick = function () {
                confirmarRemocaoNovoAnexo(input, linha);
            };
            celulaExcluir.appendChild(botao);
            celulaExcluir.style.textAlign = 'center';
        }
    };

    novosAnexosContainer.appendChild(input);
    input.click();
}


function limparNomeArquivo(nome) {
    return nome.replace(/^[^_]+_/, '');
}

function adicionarAnexoNaLista(input) {
    const container = document.getElementById('anexos-existentes');

    const tabela = container.querySelector('table') || (() => {
        const novaTabela = document.createElement('table');
        novaTabela.classList.add('tabela-anexos');
        container.appendChild(novaTabela);
        return novaTabela;
    })();

    Array.from(input.files).forEach(arquivo => {
        const linha = tabela.insertRow();

        const celulaNome = linha.insertCell();
        celulaNome.textContent = limparNomeArquivo(arquivo.name);


        const celulaExcluir = linha.insertCell();
        const botao = document.createElement('button');
        botao.type = 'button';
        botao.classList.add('btn-remover-anexo');
        botao.innerHTML = '<i class="fas fa-trash-alt btn-rmv rmv"></i>';
        botao.onclick = function () {
            linha.remove();
            input.remove();
        };
        celulaExcluir.appendChild(botao);
        celulaExcluir.style.textAlign = 'center';
    });

    input.value = '';
}

</script>

<script>
    let recadoIdParaExcluir = null;

    function abrirModalExclusaoRecado(recadoId) {
        recadoIdParaExcluir = recadoId;
        document.getElementById("modalConfirmarExclusaoRecado").style.display = "flex";
    }

    function fecharModalExclusaoRecado() {
        recadoIdParaExcluir = null;
        document.getElementById("modalConfirmarExclusaoRecado").style.display = "none";
    }

    function confirmarExclusaoRecadoFinal() {
        if (recadoIdParaExcluir) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '../php/recado-excluir.php';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'recado_id';
            input.value = recadoIdParaExcluir;
            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
        }
    }

</script>

<script>

    document.addEventListener("DOMContentLoaded", function () {
        const btnAddAnexo = document.querySelector("#secao-enviar .addAnexo");
        const container = document.querySelector("#secao-enviar #anexos-container");

        if (btnAddAnexo && container) {
            btnAddAnexo.addEventListener("click", function () {
                const novoInput = document.createElement("input");
                novoInput.type = "file";
                novoInput.name = "arquivos[]";
                novoInput.className = "arquivo-input";
                novoInput.style.marginBottom = "10px";
                novoInput.style.width = "100%";
                container.appendChild(novoInput);
            });
        }
    });
</script>

    <script src="../js/script.js"></script>
</body>
</html>
