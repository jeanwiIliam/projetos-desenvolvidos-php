<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/home.css">
    <script src="js/slider-home.js" defer></script>
    <script src="js/theme.js" defer></script>
    <title>Home</title>

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
                <a class="hov" href="">Categorias  <i style="font-size: 10px;" class='bx bxs-down-arrow'></i></a>
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

        <div class="container-slider">
            <button id="prev-button"><img src="img/arrow.png" alt=""></button>
            <div class="container-images">
                <img src="img/bannerCapa.jpg" alt="" class="slider on">
                <img src="img/banner1.jpg" alt="" class="slider">
                <img src="img/banner2.jpg" alt="" class="slider">
                <img src="img/banner3.jpg" alt="" class="slider">
            </div>
            <button id="next-button"><img src="img/arrow.png" alt=""></button>
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