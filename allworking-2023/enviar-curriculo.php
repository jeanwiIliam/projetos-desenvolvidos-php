<?php
    session_start();

    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)){
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: login.php');
    }
    else{

  


    /*****************************************/

    $deficiencia = $_GET['d'];
    $empresa = $_GET['e'];
    $vaga = $_GET['v'];

    if($deficiencia == 'm'){
        $deficiencia = 'motora';    
    }
    else if($deficiencia == 'v'){
        $deficiencia = 'visual';
    }
    else if($deficiencia == 'a'){
        $deficiencia = 'auditiva';
    }
    else{
        $deficiencia = 'não escolhida';
    }

    /*****************************************/

    if($empresa == 'bra'){
        $empresa = 'Bradesco';
    }
    else if($empresa == 'bdb'){
        $empresa = 'Banco do Brasil';
    }
    else if($empresa == 'cxa'){
        $empresa = 'Caixa Econômica';
    }
    else if($empresa == 'dgs'){
        $empresa = 'Drogasil';
    }
    else if($empresa == 'glo'){
        $empresa = 'Globant';
    }
    else if($empresa == 'hon'){
        $empresa = 'Honda';
    }
    else if($empresa == 'ita'){
        $empresa = 'Itaú';
    }
    else if($empresa == 'ibm'){
        $empresa = 'IBM';
    }
    else if($empresa == 'loc'){
        $empresa = 'Localiza';
    }
    else if($empresa == 'mag'){
        $empresa = 'Magalu';
    }
    else if($empresa == 'mar'){
        $empresa = 'Marisa';
    }
    else if($empresa == 'nat'){
        $empresa = 'Natura';
    }
    else if($empresa == 'rai'){
        $empresa = 'Raízen';
    }
    else if($empresa == 'rea'){
        $empresa = 'Real Bebidas';
    }
    else if($empresa == 'rdc'){
        $empresa = 'Rede Conecta';
    }
    else if($empresa == 'ren'){
        $empresa = 'Renner';
    }
    else if($empresa == 'sam'){
        $empresa = 'Samsung';
    }
    else if($empresa == 'tor'){
        $empresa = 'Torra';
    }
    else if($empresa == 'wom'){
        $empresa = 'Womp';
    }
    else{
        $empresa = 'Empresa não escolhida';
    }

    /*****************************************/

    if ($vaga == 'ana'){
        $vaga = 'Analista';
    }
    else if($vaga == 'ans'){
        $vaga = 'Analista de sistemas';
    }
    else if($vaga == 'aprh'){
        $vaga = 'Aprendiz de RH';
    }
    else if($vaga == 'apsv'){
        $vaga = 'Aprendiz de setor de vendas';
    }
    else if($vaga == 'apti'){
        $vaga = 'Aprendiz de TI';
    }
    else if($vaga == 'ate'){
        $vaga = 'Atendente';
    }
    else if($vaga == 'auad'){
        $vaga = 'Auxiliar administrativo';
    }
    else if($vaga == 'auex'){
        $vaga = 'Auxiliar de expedição';
    }
    else if($vaga == 'audp'){
        $vaga = 'Auxiliar de produção';
    }
    else if($vaga == 'aurh'){
        $vaga = 'Auxiliar de RH';
    }
    else if($vaga == 'ausm'){
        $vaga = 'Auxiliar de setor de manutenção';
    }
    else if($vaga == 'ause'){
        $vaga = 'Auxiliar de setor elétrico';
    }
    else if($vaga == 'ausf'){
        $vaga = 'Auxiliar de setor financeiro';
    }
    else if($vaga == 'auso'){
        $vaga = 'Auxiliar de suporte online';
    }
    else if($vaga == 'cai'){
        $vaga = 'Caixa';
    }
    else if($vaga == 'dew'){
        $vaga = 'Design web';
    }
    else if($vaga == 'fis'){
        $vaga = 'Fiscal';
    }
    else if($vaga == 'lpr'){
        $vaga = 'Linha de produção';
    }
    else if($vaga == 'man'){
        $vaga = 'Manobrista';
    }
    else if($vaga == 'prw'){
        $vaga = 'Programador web';
    }
    else if($vaga == 'rec'){
        $vaga = 'Recepcionista';
    }
    else if($vaga == 'rep'){
        $vaga = 'Repositor';
    }
    else if($vaga == 'sea'){
        $vaga = 'Setor administrativo';
    }
    else if($vaga == 'sec'){
        $vaga = 'Setor comercial';
    }
    else if($vaga == 'sev'){
        $vaga = 'Setor de vendas';
    }
    else if($vaga == 'sem'){
        $vaga = 'Setor de manutenção';
    }
    else if($vaga == 'sef'){
        $vaga = 'Setor financeiro';
    }
    else{
        $vaga = 'Vaga não escolhida';
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/curriculo.css">
    <script src="js/theme.js" defer></script>
    <title>Enviar currículo</title>

</head>
<body id="text">
    <header>
        <div class="header1">
            <div class="logo">
                <a href="#"><img class="light-logo" src="img/logo.png" alt="Logo All Working"></a>
                <a href="#"><img class="dark-logo" src="img/logo2.png" alt="Logo All Working"></a>
            </div>
        </div>

        <div class="header2">
            <div class="categorias">
                <a href="">Categorias  <i style="font-size: 10px;" class='bx bxs-down-arrow'></i></a>
                <div class="dropdown-categorias">
                    <a href="deficiencia-motora.php">Deficiência motora</a>
                    <a href="deficiencia-visual.php">Deficiência visual</a>
                    <a href="deficiencia-auditiva.php">Deficiência auditiva</a>
                </div>
            </div>

        <?php
            include_once('php/conexao.php');
            if((isset($_SESSION['email']) == true) and (isset($_SESSION['senha']) == true)){
                echo "<div class='enviados'><a class='hov' href='enviados.php'>Enviados</a></div>";
            }
        ?>

        </div>

        <div class="header3">


<?php
                include_once('php/conexao.php');
                if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)){
                    unset($_SESSION['email']);
                    unset($_SESSION['senha']);
                    echo "<a class='log_cad' href='login.php'>Login</a>";
                    echo "<a class='log_cad' href='cadastro.php'>Cadastre-se</a>";
                }
                else{
                    $email = $_SESSION['email'];
                    $senha = $_SESSION['senha'];
                    $sql = "SELECT * FROM usuario WHERE email = '$email' and senha = '$senha'";
                    $res = $con->query($sql);
                    if($res->num_rows > 0)
                    {
                        while($reg = mysqli_fetch_assoc($res))
                        {
                            $nome = $reg['nome'];
                            $cpf = $reg['cpf'];
                        }
                    }
                    $aux = explode(" ",$nome);


                    echo "<h4 class='nome'>Olá, "."$aux[0]</h4>";
                    echo "<a class='sair' href='php/sair.php'>Sair</a>";
                }
?>


        </div>
    </header>


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
            <div class="area-curriculo">


                <div class="curriculo">
                    <div class="upload-curriculo">
                        <img src="img/uploadIcon.png" alt="">
                        <h2>Envie seu currículo</h2>
                        <br>
                        <form action="php/dadosCurriculo.php" method="POST" enctype="multipart/form-data">
                            <input class="arquivo" type="file" name="arquivo">
                            <?php
                                if(isset($_SESSION['msg'])){
                                    echo "<br><br>";
                                    echo $_SESSION['msg'];
                                    unset($_SESSION['msg']);
                                }
                            ?>
                            
                    </div>
                </div>

            </div>
     
            <div class="area-dados">
                <div class="dados">
                    <h2>Daods selecionados:</h2>
                    <div class="dado-escolhido"><?php echo "Categoria ".$deficiencia ?></div>
                    <div class="dado-escolhido"><?php echo $empresa ?></div>
                    <div class="dado-escolhido"><?php echo $vaga ?></div>

                    <input type="hidden" name="deficiencia" value = "<?php echo $deficiencia ?>">
                    <input type="hidden" name="empresa" value = "<?php echo $empresa ?>">
                    <input type="hidden" name="vaga" value = "<?php echo $vaga ?>">
                    <input type="hidden" name="cpf" value = "<?php echo $cpf ?>">
                 
                    <div class="area-button">
                        <button class="button" type="submit" name="enviar">Enviar</button>
                    </div>

                        </form>

                </div>
            </div>
        </div>
        
    </main>


    <footer>
        <ul class="contatos">
            <li>
                <i class='bx bx-envelope' ></i>
                <p>allworking@gmail</p>
            </li>
            <li>
                <i class='bx bxs-phone'></i>
                <p>(92)99123-4567</p>
            </li>
            <li>
                <i class='bx bxl-instagram' ></i>
                <p>@allworking</p>
            </li>
            <li>
                <i class='bx bxl-facebook-square' ></i>
                <p>All Working</p>
            </li>
        </ul>
    </footer>


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

<?php
  }
?>