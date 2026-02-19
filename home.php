<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Three Hugs</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="estilos/home.css">
  <!-- Ícones da página -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>

<body>
        <header class="header">
            <!--Menu superior -->
            <div class="menu-sup">
                <nav class="nav">
                    <a class="ativo">HOME</a>
                    <a class="inativo" href="Ong.php">ONG</a>
<?php
                if((isset($_SESSION['email']) == true) and (isset($_SESSION['senha']) == true)){
                    echo "<a class='inativo' href='Rastreio/rastreio.php'>RASTREIO</a>";
                }
?>
                    <a class="inativo" href="fale-conosco.php">FALE CONOSCO</a>
                </nav>
            </div>
            <div class="nav-button">
                <nav class="nav2">


<?php
                include_once('php/conexao.php');
                if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)){
                    unset($_SESSION['email']);
                    unset($_SESSION['senha']);
                    echo "<a href='login.php'>Login</a>";
                    echo "<a href='cadastro/cadastro.php'>Cadastre-se</a>";
                }
                else{
                    $email = $_SESSION['email'];
                    $senha = $_SESSION['senha'];
                    $sql = "SELECT * FROM cliente WHERE email = '$email' and senha = '$senha'";
                    $res = $con->query($sql);
                    if($res->num_rows > 0)
                    {
                        while($reg = mysqli_fetch_assoc($res))
                        {
                            $nome = $reg['nome'];
                        }
                    }
                    $aux = explode(" ",$nome);


                    echo "<div style='left: 75px'; class='dropdown'>";
                    echo "<button class='dropbtn'><h3 style= 'color:white';>Olá, "."$aux[0]</h3></button>";
                    echo "<div class='dropdown-content'>";
                    echo "<a href='meus-dados.php'>Meus Dados</a>";
                    echo "<a href='sair.php'>Sair</a>";
                    echo "</div>";
                    echo "</div>";
                }
?>
                </nav>
            </div>
        </header>

        <div class="container">

            <div class="banner">
                <div class="banner-img">
                    <img class="img" src="foto agora/logo-nova2.png"/>
                </div>
                <div class="texto">
                    <p>Seja muito bem-vindo ao Three Hugs. Aqui você pode ajudar ongs de vários setores, como … e as ongs que cuidam dos nossos amigos de 4 patas.
                        Através do nosso site você pode efetuar transferências via Pix ou Ted e em contato direto com as ongs você poderá fazer doações de cestas básicas, produtos de higiene pessoal, entre outros.
                        Nos colocamos à disposição no e-mail: contato@threehugs.com
                        Obrigado por vir nos conhecer e nos ajudar. <br>
                    
                        Equipe Three Hugs.</p>
                </div>
            </div>
            
            <div class="container2">
                <div id="meuCarousel" class="carousel slide" data-ride="carousel">
                    <!--Indicadores-->
                    <ol class="carousel-indicators">
                        <li data-target="#meuCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#meuCarousel" data-slide-to="1"></li>
                        <li data-target="#meuCarousel" data-slide-to="2"></li>
                        <li data-target="#meuCarousel" data-slide-to="3"></li>
                        <li data-target="#meuCarousel" data-slide-to="4"></li>
                        <li data-target="#meuCarousel" data-slide-to="5"></li>
                        <li data-target="#meuCarousel" data-slide-to="6"></li>
                        <li data-target="#meuCarousel" data-slide-to="7"></li>
                        <li data-target="#meuCarousel" data-slide-to="8"></li>
                        <li data-target="#meuCarousel" data-slide-to="9"></li>
                        <li data-target="#meuCarousel" data-slide-to="10"></li>
                        <li data-target="#meuCarousel" data-slide-to="11"></li>
                    </ol>
                    <!--Slides-->
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="foto agora/cancer.png" alt="Banner principal" title="Banner 1">
                            <div class="carousel-caption">
                            </div>
                        </div>
                        <div class="item">
                            <img src="foto agora/culture.png" alt="Banner número 2" title="Banner 2">
                        </div>
                        <div class="item">
                            <img src="foto agora/desenvolvimento2.png" alt="Banner número 3" title="Banner 3">
                        </div>
                        <div class="item">
                            <img src="foto agora/direito infantil.png" alt="Banner número 4" title="Banner 4">
                        </div>
                        <div class="item">
                            <img src="foto agora/empoderamento feminino.png" alt="Banner número 5" title="Banner 5">
                        </div>
                        <div class="item">
                            <img src="foto agora/enviroment.png" alt="Banner número 6" title="Banner 6">
                        </div>
                        <div class="item">
                            <img src="foto agora/esporte.png" alt="Banner número 7" title="Banner 7">
                        </div>
                        <div class="item">
                            <img src="foto agora/estudo.png" alt="Banner número 8" title="Banner 8">
                        </div>
                        <div class="item">
                            <img src="foto agora/preotecao animal.png" alt="Banner número 9" title="Banner 9">
                        </div>
                        <div class="item">
                            <img src="foto agora/proteção de cachorro.png" alt="Banner número 9" title="Banner 10">
                        </div>
                        <div class="item">
                            <img src="foto agora/saude.png" alt="Banner número 9" title="Banner 11">
                        </div>
                        <div class="item">
                            <img src="foto agora/inclusão social.png" alt="Banner número 9" title="Banner 12">
                        </div>
                    </div>
                    <!--Controladores(setas)-->
                    <a href="#meuCarousel" class="left carousel-control" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        <span class="sr-only">Anterior</span>
                    </a>
                    <a href="#meuCarousel" class="right carousel-control" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">Próximo</span>
                    </a>
                </div>
            </div>
        </div>

        <footer class="footer"></footer>
</body>
</html>