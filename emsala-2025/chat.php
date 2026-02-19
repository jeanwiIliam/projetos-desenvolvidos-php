<?php
session_start();
include 'php/db.php';

if (!isset($_SESSION['user']) || !isset($_SESSION['tipo'])) {
    header("Location: login.php");
    exit();
}

$usuarioLogadoId = $_SESSION['id'];
$usuarioLogadoNome = $_SESSION['user'];
$tipoUsuario = $_SESSION['tipo'];
$primeiroNome = explode(' ', $usuarioLogadoNome)[0];

if (!isset($_GET['stdid'])) {
    echo "Usuário destino não especificado.";
    exit();
}

$destinoId = intval($_GET['stdid']);
$destinoNome = '';

if ($tipoUsuario === 'professor') {
    $res = $conn->query("
        SELECT R.RES_id, R.RES_nome 
        FROM responsavel R
        INNER JOIN aluno_responsavel AR ON AR.ALR_RES_id = R.RES_id
        WHERE AR.ALR_ALU_id = $destinoId
        LIMIT 1
    ");
    if ($res->num_rows === 0) {
        echo "Responsável não encontrado para esse aluno.";
        exit();
    }
    $dados = $res->fetch_assoc();
    $destinoNome = $dados['RES_nome'];
    $destinoId = $dados['RES_id'];

} elseif ($tipoUsuario === 'responsavel') {
    $res = $conn->query("SELECT PRO_nome FROM professor WHERE PRO_id = $destinoId");
    if ($res->num_rows === 0) {
        echo "Professor não encontrado.";
        exit();
    }
    $dados = $res->fetch_assoc();
    $destinoNome = $dados['PRO_nome'];
} else {
    echo "Tipo de usuário inválido.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
        }

        .chat-container {
            display: flex;
            flex-direction: column;
            height: 100vh;
            border: 1px solid #38356b;
            width: 450px;
        }

        .chat-header {
            background-color: #38356b;
            color: white;
            padding: 15px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #ccc;
        }

        .chat-header img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .chat-header h2 {
            font-size: 18px;
            margin: 0;
        }

        .chat-messages {
            flex: 1;
            padding: 15px;
            overflow-y: auto;
            background-color: rgb(249, 246, 255);
        }

        .chat-input {
            display: flex;
            border-top: 1px solid #ccc;
            padding: 10px;
            background-color: #fff;
        }

        .chat-input input[type="text"] {
            flex: 1;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .chat-input button {
            padding: 10px 20px;
            margin-left: 10px;
            background-color: #bd6502;
            color: #fff;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .chat-input button:hover {
            background-color: #d97706;
        }

        .chat-message {
            margin-bottom: 10px;
        }

        .chat-message p {
            margin: 0;
            padding: 8px 12px;
            background-color: rgb(75, 75, 75);
            color: white;
            border-radius: 8px;
            display: inline-block;
            max-width: 350px;
            word-wrap: break-word;
            text-align: left;
        }

        .sent {
            text-align: right;
        }

        .sent p {
            background-color: #43407F;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <img src="img/profile-pic-L.png" alt="Foto de perfil">
            <h2><?php echo htmlspecialchars($destinoNome); ?></h2>
        </div>

        <div class="chat-messages" id="chatMessages">
            <div class="chat-message sent">
                <p>Olá, tudo bem?</p>
            </div>
            <div class="chat-message">
                <p>Olá, <?php echo htmlspecialchars($primeiroNome); ?>! Tudo sim e com você?</p>
            </div>
        </div>

        <div class="chat-input">
            <input type="text" id="mensagemInput" placeholder="Digite sua mensagem...">
            <button onclick="enviarMensagem()">Enviar</button>
        </div>
    </div>

    <script>
        function enviarMensagem() {
            const input = document.getElementById('mensagemInput');
            const texto = input.value.trim();
            if (texto !== '') {
                const div = document.createElement('div');
                div.className = 'chat-message sent';
                div.innerHTML = `<p>${texto}</p>`;
                document.getElementById('chatMessages').appendChild(div);
                input.value = '';
                document.getElementById('chatMessages').scrollTop = document.getElementById('chatMessages').scrollHeight;
                // Salvamento necessario via AJAX
            }
        }
    </script>
</body>
</html>
