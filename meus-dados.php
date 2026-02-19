<?php
    session_start();
    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)){
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: login.php');
    }
    
    include_once('php/conexao.php');
    
    $email = $_SESSION['email'];
    $senha = $_SESSION['senha'];
    $sql = "SELECT * FROM cliente WHERE email='$email' and senha='$senha'";
    $res = $con->query($sql);
    if($res->num_rows > 0)
    {
        while($reg = mysqli_fetch_assoc($res))
        {
            $nome = $reg['nome'];
            $cpf = $reg['cpf'];
            $rg = $reg['rg'];
            $data_nasc = $reg['datanascimento'];
            $telefone = $reg['telefone'];
            $genero = $reg['genero'];
            $estado = $reg['estado'];
            $cidade = $reg['cidade'];
            $cep = $reg['cep'];
            $bairro = $reg['bairro'];
            $rua = $reg['rua'];
            $numero = $reg['num'];
            $complemento = $reg['complemento'];
            $email = $reg['email'];
            $senha = $reg['senha'];
        }
    }

?>

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
    <link rel="stylesheet" href="estilos/cadastro.css">
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
                            <h1>Meus Dados</h1>
                        </div>
                        <img style="width: 120px; height: 100px; margin-top: 20px;" src="foto agora/logo-nova2.png"/>
                    </div>
    
                    <!--Inputs-->
                    <div class="input-group">
                        <h5>Dados pessoais</h5>
                        <!--Nome-->
                        <div class="input-box input-name">
                            <label for="name">Nome Completo</label>
                            <input id="name" type="text" name="nome" value = "<?php echo $nome ?>">
                        </div>
                        <!--CPF-->
                        <div class="input-box">
                            <label for="cpf">CPF</label>
                            <input id="cpf" type="text" name="cpf" value = "<?php echo $cpf ?>" onkeypress="$(this).mask('000.000.000-00')">
                        </div>
                        <!--Telefone-->
                        <div class="input-box">
                            <label for="telefone">Telefone</label>
                            <input id="telefone" type="tel" name="telefone" value = "<?php echo $telefone ?>" onkeypress="$(this).mask('(00) 00000-0000')">
                        </div>
                        <!--RG-->
                        <div class="input-box">
                            <label for="rg">RG</label>
                            <input id="rg" type="text" name="rg" value = "<?php echo $rg ?>" required onkeypress="$(this).mask('0000000-0')">
                        </div>
                        <!--Data de Nascimento-->
                        <div class="input-box">
                            <label for="date">Data de Nascimento</label>
                            <input id="date" type="text" name="date" value = "<?php echo $data_nasc ?>" required onkeypress="$(this).mask('00/00/0000')">
                        </div>
                    </div>
    
                    <!--Input de escolha (gênero)-->
                    <div class="gender-inputs">
                        <!--Título da div gender-inputs-->
                        <div class="gender-title">
                            <h6>Gênero</h6>
                        </div>
    
                        <!--Opções-->
                        <div class="gender-group">
                            <div class="gender-input">
                                <input type="radio" id="male" name="genero" value="masculino" <?php echo ($genero == 'masculino') ? 'checked' : '' ?>>
                                <label for="male">Masculino</label>
                            </div>
                            <div class="gender-input">
                                <input type="radio" id="female" name="genero" value="feminino" <?php echo ($genero == 'feminino') ? 'checked' : '' ?> >
                                <label for="female">Feminino</label>
                            </div>
                            <div class="gender-input">
                                <input type="radio" id="others" name="genero" value="outro" <?php echo ($genero == 'outro') ? 'checked' : '' ?>>
                                <label for="others">Outro</label>
                            </div>
                            <div class="gender-input">
                                <input type="radio" id="noinform" name="genero" value="não informado" <?php echo ($genero == 'não informado') ? 'checked' : '' ?>>
                                <label for="noinform">Não informar</label>
                            </div>
                        </div>
                    </div>

                    <!-- ****************************ENDEREÇO****************************** -->

                    <div class="input-group2">
                        <h5>Dados de endereço</h5>
                    <!--Estado-->
                    <div class="input-box">
                        <label for="estado">Estado</label>
                        <input id="estado" type="text" name="estado" value = "<?php echo $estado ?>" required>
                    </div>
                    <!--Cidade-->
                    <div class="input-box">
                        <label for="cidade">Cidade</label>
                        <input id="cidade" type="text" name="cidade" value = "<?php echo $cidade ?>" required>
                    </div>
                    <!--CEP-->
                    <div class="input-box">
                        <label for="cep">CEP</label>
                        <input id="cep" type="text" name="cep" value = "<?php echo $cep ?>" required onkeypress="$(this).mask('00000-000')">
                    </div>
                    <!--Bairo-->
                    <div class="input-box">
                        <label for="bairro">Bairro</label>
                        <input id="bairro" type="text" name="bairro" value = "<?php echo $bairro ?>" required >
                    </div>
                    <!--Rua-->
                    <div class="input-box input-rua">
                        <label for="rua">Logradouro</label>
                        <input id="rua" type="text" name="rua" value = "<?php echo $rua ?>" required>
                    </div>
                    <!--Número-->
                    <div class="input-box input-num">
                        <label for="numero">Nº</label>
                        <input id="numero" type="text" name="numero" value = "<?php echo $numero ?>" required >
                    </div>
                    <!--Complemento-->
                    <div class="input-box input-name">
                        <label for="complemento">Complemento</label>
                        <input id="complemento" type="text" name="complemento" value = "<?php echo $complemento ?>">
                    </div>                    
                </div>

                    <!-- ******************************EMAIL SENHA***************************** -->

                    <div class="input-group3">
                        <h5>Dados de login</h5>
                        <!--Email-->
                        <div class="input-box input-name">
                            <label for="email">Email</label>
                            <input id="email" type="email" name="email" value = "<?php echo $email ?>">
                        </div>
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