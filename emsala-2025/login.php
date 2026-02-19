<!DOCTYPE html>
<html lang="pt-BR"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="container">
        <div class="user-type-selector">
            <button class="user-btn active" data-type="administrador">Administrador</button>
            <button class="user-btn" data-type="professor">Professor</button>
            <button class="user-btn" data-type="aluno">Aluno</button>
            <button class="user-btn" data-type="responsavel">Responsável</button>
        </div>

        <div class="login-form">
            <h2 id="form-title">Login - Administrador</h2>
            <form action="php/efetuarLogin.php" method="POST">
                <input type="hidden" name="tipo" id="tipoUsuario" value="administrador">
                <input type="email" name="email" placeholder="E-mail" required>
                <input type="password" name="senha" placeholder="Senha" required>
                <button type="submit">Entrar</button>
            </form>
            <p id="cadastro-paragrafo">Não tem uma conta? <a href="cadastro.php" class="cad-link">Cadastre-se</a></p>
        </div>
    </div>

    <script>
        const buttons = document.querySelectorAll(".user-btn");
        const tipoInput = document.getElementById("tipoUsuario");
        const title = document.getElementById("form-title");
        const cadastroParagrafo = document.getElementById("cadastro-paragrafo");

        buttons.forEach(btn => {
            btn.addEventListener("click", () => {
                buttons.forEach(b => b.classList.remove("active"));
                btn.classList.add("active");

                const tipo = btn.dataset.type;
                tipoInput.value = tipo;
                title.innerText = "Login - " + tipo.charAt(0).toUpperCase() + tipo.slice(1);
                if(title.innerText == "Login - Responsavel"){
                    title.innerText = "Login - Responsável";
                }

                cadastroParagrafo.style.display = (tipo === "administrador") ? "block" : "none";
            });
        });
    </script>
</body>
</html>
