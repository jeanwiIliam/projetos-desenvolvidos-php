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
    <script> src="https://www.gstatic.com/firebasejs/9.7.0/firebase-app.js"</script>
    <link rel="stylesheet" href="../estilos/cadastro.css">
    <title>Cadastro</title>
</head>
<body>

    <div class="main">
        <header class="header">
        </header>
        <br><br>
        <div class="container">
            <div class="form">
                <!--Formulário-->
                <form action="../php/dadosCadastro.php" method="POST">
                    <!--Cabeçalho do formulário-->
                    <div class="form-header">
                        <div class="title">
                            <h1 style="margin-bottom: 0;">Cadastre-se</h1>
                        </div>
                        <img style="width: 120px; height: 100px; margin-top: 20px;" src="../foto agora/logo-nova2.png"/>
                    </div>
                    <p style="color: red; font-size: 13px; margin-bottom: 20px;">* Campo de preenchimento obrigatório</p>
                    <!--Inputs-->
                    <div class="input-group">
                        <h5>Dados pessoais</h5>
                        <!--Nome-->
                        <div class="input-box input-name">
                            <label for="name">Nome Completo <span style="color: red;">*</span> </label>
                            <input id="name" type="text" name="nome" placeholder="Digite seu nome completo" required>
                        </div>
                        <!--CPF-->
                        <div class="input-box">
                            <label for="cpf">CPF <span style="color: red;">*</span></label>
                            <input id="cpf" type="text" name="cpf" placeholder="Digite seu CPF" required onkeypress="$(this).mask('000.000.000-00')">
                        </div>
                        <!--Telefone-->
                        <div class="input-box">
                            <label for="telefone">Telefone <span style="color: red;">*</span></label>
                            <input id="telefone" type="tel" name="telefone" placeholder="(xx) xxxxx-xxxx" required onkeypress="$(this).mask('(00) 00000-0000')">
                        </div>
                        <!--RG-->
                        <div class="input-box">
                            <label for="rg">RG <span style="color: red;">*</span></label>
                            <input id="rg" type="text" name="rg" placeholder="Digite seu RG" required onkeypress="$(this).mask('0000000-0')">
                        </div>
                        <!--Data de Nascimento-->
                        <div class="input-box">
                            <label for="date">Data de Nascimento <span style="color: red;">*</span></label>
                            <input id="date" type="text" name="date" placeholder="Data de Nascimento" required onkeypress="$(this).mask('00/00/0000')">
                        </div>
                    </div>
    
                    <!--Input de escolha (gênero)-->
                    <div class="gender-inputs">
                        <!--Título da div gender-inputs-->
                        <div class="gender-title">
                            <h6>Gênero <span style="color: red;">*</span></h6>
                        </div>
    
                        <!--Opções-->
                        <div class="gender-group">
                            <div class="gender-input">
                                <input type="radio" id="male" name="genero" value="masculino" required>
                                <label for="male">Masculino</label>
                            </div>
                            <div class="gender-input">
                                <input type="radio" id="female" name="genero" value="feminino" required>
                                <label for="female">Feminino</label>
                            </div>
                            <div class="gender-input">
                                <input type="radio" id="others" name="genero" value="outro" required>
                                <label for="others">Outro</label>
                            </div>
                            <div class="gender-input">
                                <input type="radio" id="noinform" name="genero" value="não informado" required>
                                <label for="noinform">Não informar</label>
                            </div>
                        </div>
                    </div>

                    <!-- ****************************ENDEREÇO****************************** -->

                    <div class="input-group2">
                        <h5>Dados de endereço</h5>
                    <!--Estado-->
                    <div class="input-box">
                        <label for="estado">Estado <span style="color: red;">*</span></label>
                        <input id="estado" type="text" name="estado" placeholder="Insira seu Estado" required>
                    </div>
                    <!--Cidade-->
                    <div class="input-box">
                        <label for="cidade">Cidade <span style="color: red;">*</span></label>
                        <input id="cidade" type="text" name="cidade" placeholder="Insira sua Cidade" required>
                    </div>
                    <!--CEP-->
                    <div class="input-box">
                        <label for="cep">CEP</label>
                        <input id="cep" type="text" name="cep" placeholder="Insira seu CEP" required onkeypress="$(this).mask('00000-000')">
                    </div>
                    <!--Bairo-->
                    <div class="input-box">
                        <label for="bairro">Bairro <span style="color: red;">*</span></label>
                        <input id="bairro" type="text" name="bairro" placeholder="Insira seu bairro" required >
                    </div>
                    <!--Rua-->
                    <div class="input-box input-rua">
                        <label for="rua">Logradouro <span style="color: red;">*</span></label>
                        <input id="rua" type="text" name="rua" placeholder="Insira sua Rua" required>
                    </div>
                    <!--Número-->
                    <div class="input-box input-num">
                        <label for="numero">Nº <span style="color: red;">*</span></label>
                        <input id="numero" type="text" name="numero" placeholder="Insira seu N°" required >
                    </div>
                    <!--Complemento-->
                    <div class="input-box input-name">
                        <label for="complemento">Complemento</label>
                        <input id="complemento" type="text" name="complemento" placeholder="Insira seu complemento">
                    </div>                    
                </div>

                    <!-- ******************************EMAIL SENHA***************************** -->

                    <div class="input-group3">
                        <h5>Dados de login</h5>
                        <!--Email-->
                        <div class="input-box input-name">
                            <label for="email">Email <span style="color: red;">*</span></label>
                            <input id="email" type="email" name="email" placeholder="Digite seu Email" required>
                        </div>
                        <!--Senha-->
                        <div class="input-box">
                            <label for="senha">Senha <span style="color: red;">*</span></label>
                            <input id="senha" type="password" name="senha" placeholder="Digite sua senha" required >
                        </div>
                        <!--Confirme Senha-->
                        <div class="input-box">
                            <label for="confirmsenha">Confirme sua senha <span style="color: red;">*</span></label>
                            <input id="confirmsenha" type="password" name="confirmsenha" placeholder="Confirme sua senha" required>
                        </div>
                    </div>
                    

                    <!--Botão-->
                    <div class="continue-button">
                        <button type="submit" name="salvar" style="color:white;">Concluir Cadastro</button>
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