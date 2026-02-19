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
            <form action="email-senha.php" method="POST">
                <!--Cabeçalho do formulário-->
                <div class="form-header">
                    <div class="title">
                        <h1>Cadastre-se</h1>
                    </div>
                    <div class="login-button">
                        <button> <a href="#">Entrar</a> </button>
                    </div>
                </div>

                <!--Inputs-->
                <div class="input-group">
                    <!--Estado-->
                    <div class="input-box">
                        <label for="estado">Estado</label>
                        <input id="estado" type="text" name="estado" placeholder="Insira seu Estado" required>
                    </div>
                    <!--Cidade-->
                    <div class="input-box">
                        <label for="city">Cidade</label>
                        <input id="city" type="text" name="city" placeholder="Insira sua Cidade" required>
                    </div>
                    <!--CEP-->
                    <div class="input-box">
                        <label for="cep">CEP</label>
                        <input id="cep" type="text" name="cep" placeholder="Insira seu CEP" required onkeypress="$(this).mask('00000-000')">
                    </div>
                    <!--Bairo-->
                    <div class="input-box">
                        <label for="bairro">Bairro</label>
                        <input id="bairro" type="text" name="bairro" placeholder="Insira seu bairro" required >
                    </div>
                    <!--Rua-->
                    <div class="input-box input-rua">
                        <label for="rua">Rua</label>
                        <input id="rua" type="text" name="rua" placeholder="Insira sua Rua" required>
                    </div>
                    <!--Número-->
                    <div class="input-box input-num">
                        <label for="numero">Nº</label>
                        <input id="numero" type="text" name="numero" placeholder="Insira seu N°" required >
                    </div>
                    <!--Complemento-->
                    <div class="input-box input-name">
                        <label for="complemento">Complemento</label>
                        <input id="complemento" type="text" name="complemento" placeholder="Insira seu complemento" required >
                    </div>                    
                </div>

                <!--Botão-->
                <div class="continue-button endereco">
                    <button><a href="email-senha.php">Continuar</a></button>
                </div>
            </form>
        </div>
    </div>

    <div id="borda-inferior"></div>

</body>

</html>