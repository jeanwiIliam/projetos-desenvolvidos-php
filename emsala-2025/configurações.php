<?php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['id']) || $_SESSION['tipo'] !== 'administrador') {
    header("Location: ../login.php");
    exit();
}

$nome_completo = $_SESSION['user'];
$adminID = $_SESSION['id'];
$nome = explode(' ', $nome_completo)[0];

include 'php/db.php';

$mensagem = "";
$mensagemExito = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $novaSenha = trim($_POST['nova_senha']);
    $confirmarSenha = trim($_POST['confirmar_senha']);
    if (empty($novaSenha) || empty($confirmarSenha)) {
        $mensagem = "Por favor, preencha todos os campos.";
    } elseif (strlen($novaSenha) > 8) {
        $mensagem = "A senha deve ter no máximo 8 caracteres.";
    } elseif ($novaSenha !== $confirmarSenha) {
        $mensagem = "As senhas não coincidem.";
    } else {
        $senhaCriptografada = password_hash($novaSenha, PASSWORD_DEFAULT);
        $query = "UPDATE administrador SET ADM_senha = ? WHERE ADM_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $senhaCriptografada, $adminID);

        if ($stmt->execute()) {
            $mensagemExito = "Senha atualizada com sucesso!";
        } else {
            $mensagem = "Erro ao atualizar a senha.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações - Administrador</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<main>
    <div class="sidebar" id="sidebar">
        <button id="menuToggle"><span id="menuIcon">&#9664;</span></button>
            <div class="sidebar_logo"><i class="fa-solid fa-chalkboard-user"id="nav_logo"> Em Sala</i></div>
        <div class="profile">
            <img src="img/profile-pic-L.png" alt="Foto de perfil do administrador" class="foto-sidebar">
            <?php echo "<p>Bem-vindo</br>".$nome."</p>"?>
        </div>
        <nav class="sidebar_nav">
            <ul class="sidebar_nav_links">
                <a href="painel.php"><li>Painel</li></a>
                <a href="pesquisar.php"><li>Pesquisar</li></a>
                <a href="configuracoes.php"><li class="side_active">Configurações</li></a>
                <a href="php/logout.php"><li>Sair</li></a>
            </ul>
        </nav>
    </div>

    <div class="content">
        <div class="header">
            <h1>Alterar Senha</h1>
        </div>
        <div class="container">
            <form method="POST" class="form-senha">
                <label for="nova_senha">Nova Senha (máx. 8 caracteres):</label>
                <input type="password" id="nova_senha" name="nova_senha" maxlength="8" required>

                <label for="confirmar_senha">Confirmar Nova Senha:</label>
                <input type="password" id="confirmar_senha" name="confirmar_senha" maxlength="8" required>

                <button type="submit" class="button">Alterar Senha</button>

                <?php
                    if (!empty($mensagem)) echo "<p class='mensagem'>$mensagem</p>";
                    if (!empty($mensagemExito)) echo "<p class='mensagem-exito'>$mensagemExito</p>";
                ?>
            </form>
        </div>
    </div>
</main>

<script src="../js/script.js"></script>
</body>
</html>
