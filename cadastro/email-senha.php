<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script th:src="@{/js/valida-cep.js}"></script>
    <script th:src="@{/js/verificar-campos.js}"></script>
    <script src="../../static/js/verificar-campos.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <link rel="stylesheet" href="../estilos/editCLi.css">
    <title>Cadastro</title>
</head>
<body>

    
    <div id="bordacima"></div>

    <div class="container">
        <!-- Div da Imagem -->
        <div class="form-image">
            <img src="../logo-nova.png" alt="Formulário de Cadastro">
        </div>

        <!-- Div do Formulário -->
        <div class="form">
            <!--Formulário-->
            <form action="../php/dadosCliente.php" method="POST">
                <!--Cabeçalho do formulário-->
                <div class="form-header">
                    <div class="title">
                        <h1>Cadastre-se</h1>
                    </div>
                    
                </div>

                <!--Inputs-->
                <div class="input-group input-name"> 
                    <!--Email-->
                    <div class="input-box input-name">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" placeholder="Digite seu Email" required>
                    </div>
                    <!--Senha-->
                    <div class="input-box">
                        <label for="senha">Senha</label>
                        <input id="senha" type="password" name="senha" placeholder="Digite sua senha" required >
                    </div>
                    <!--Confirme Senha-->
                    <div class="input-box">
                        <label for="confirmsenha">Confirme sua senha</label>
                        <input id="confirmsenha" type="password" name="confirmsenha" placeholder="Confirme sua senha" required>
                    </div>

                <!--Botão-->
                <div class="continue-button input-name">
                    <button style="color:white;" type="submit" name="salvar">Concluir Cadastro</button>                </div>
            </form>
        </div>
    </div>

    <div id="borda-inferior1"></div>

</body>

</html>