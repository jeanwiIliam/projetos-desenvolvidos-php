<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/login.css">
    <!--
    <link rel="stylesheet" href="@{/css/login.css}">
    -->
    <title>Login</title>
</head>

<body>

    <!------------------------------------------------------------------------------------>

    <div class="main">
        <header class="header">
        </header>
        <br><br>
        <div class="container">
            <!--Div da imagem-->
            <div class="form-image">
                <img src="foto agora/logo-nova2.png" alt="Formulário de Cadastro">
            </div>
            <div class="form">
                <!--Formulário-->
                <form action="php/dadosLogin.php" method="POST">
                    <!--Cabeçalho do formulário-->
                    <div class="form-header">
                        <div class="title">
                            <h1>Login</h1>
                        </div>
                        <img style="width: 120px; height: 100px;" src="foto agora/logo-nova2.png"/>
                    </div>
    
                    <!--Inputs-->
                    <div class="input-group input-name"> 
                        <!--Email-->
                        <div class="input-box input-name">
                            <label for="email">Email</label>
                            <input id="email" type="email" name="email" placeholder="Digite seu Email" required>
                        </div>
                        <!--Senha-->
                        <div class="input-box input-name">
                            <label for="senha">Senha</label>
                            <input id="senha" type="password" name="senha" placeholder="Digite sua senha" required >
                        </div>
                    </div>
                    <!--Botão-->
                    <div class="continue-button input-name">
                        <button type="submit" name="logar" style="color:white;">Entrar</button>
                    </div>
   
                </form>
            </div>
        </div>
        <br><br>
        <footer class="footer">

        </footer>
    </div>

</body>

</html>