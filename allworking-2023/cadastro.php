<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/cadastro.css">
    <script src="js/theme.js" defer></script>
    <title>Cadastro</title>

</head>
<body>
 


    <main>

        <div class="acess">

            <div class="acess-contrast">
                <input style="display: none;" type="checkbox" name="change-theme" id="change-theme">
                <label for="change-theme"><i class='bx bx-adjust'></i></label>
            </div>
            
            <div class="container-acess-text">

                <div class="acess-text">
                    <i class='bx bx-font-size'></i>
                
                </div>
                <div class="drop-acess-text">
                    <span class="text-size P active" onclick="document.getElementById('text').style.fontSize = '1em'">A</span>
                    <span class="text-size M" onclick="document.getElementById('text').style.fontSize = '1.15em'">A</span>
                    <span class="text-size G" onclick="document.getElementById('text').style.fontSize = '1.30em'">A</span>
                </div>
            </div>



        </div>

        <div class="container">
            <div class="form">
                <!--Formulário-->
                <form action="php/dadosCadastro.php" method="POST" id="text">
                    <!--Cabeçalho do formulário-->
                    <div class="form-header">
                        <div class="title">
                            <h1 style="margin-bottom: 0;">Cadastre-se</h1>
                        </div>
                        <img class="light-logo" style="width: 160px; height: 50px; margin-top: 50px;" src="img/logo.png">
                        <img class="dark-logo" style="width: 160px; height: 50px; margin-top: 50px;" src="img/logo2.png">
                    </div>
                    <p style="color: red; font-size: 15px; margin-bottom: 20px;">* Campo de preenchimento obrigatório</p>
                    <!--Inputs-->
                    <div class="input-group">
                        <p class="h5">Dados pessoais</p>
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
                            <p class="h6">Gênero <span style="color: red;">*</span></p>
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
                    <br><br>
                    <!-- ******************************EMAIL SENHA***************************** -->

                    <div class="input-group3">
                        <p class="h5">Dados de login</p>
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
                        <button type="submit" name="salvar">Concluir Cadastro</button>
                    </div>
                </form>
            </div>
        </div>
        
    </main>


  


    <script>
        let buttons = document.querySelector('.drop-acess-text');
        let btn = buttons.querySelectorAll('.text-size');
        for(var i = 0; i < btn.length; i++){
            btn[i].addEventListener('click', function(){
              let current = document.getElementsByClassName('active');  
              current[0].className = current[0].className.replace("active", "");
              this.className += " active";
            })
        }
    </script>

</body>
</html>