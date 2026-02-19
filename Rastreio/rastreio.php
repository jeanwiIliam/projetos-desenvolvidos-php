<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Ícones da página -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="rastreio.css">

</head>
<body>

    <header class="header">
        <!--Menu superior -->
        <div class="menu-sup">
            <nav class="nav">
                <a class="inativo" href="../home.php" >HOME</a>
                <a class="inativo" href="../Ong.php">ONG</a>
<?php
            if((isset($_SESSION['email']) == true) and (isset($_SESSION['senha']) == true)){
                echo "<a class='ativo'>RASTREIO</a>";
            }
?>
                <a class="inativo" href="../fale-conosco.php">FALE CONOSCO</a>
            </nav>
        </div>
        <div class="nav-button">
            <nav class="nav2">


<?php
            include_once('../php/conexao.php');
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
                echo "<a href='../meus-dados.php'>Meus Dados</a>";
                echo "<a href='sair.php'>Sair</a>";
                echo "</div>";
                echo "</div>";
            }
?>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="container-header"><h2>DOAÇÃO A1B23CD4</h2></div>
        <div class="container-content">
            <div class="item">
                <div class="circle">
                    <i class="bi bi-bag">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
                            <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
                          </svg>
                    </i>
                </div>
                <div class="description">
                    <h2>Doação Recebida</h2>
                    <h4>14/05/2022 • 10h25</h4>
                </div>
            </div>
            <div class="item">
                <div class="circle">
                    <i class="bi bi-bag-check">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-bag-check" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10.854 8.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                            <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
                          </svg>
                    </i>
                </div>
                <div class="description">
                    <h2>Doação Comprovada</h2>
                    <h4>14/05/2022 • 10h30</h4>
                </div>
            </div>
            <div class="item">
                <div class="circle">
                    <i class="bi bi-truck">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
                            <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                          </svg>
                    </i>
                </div>
                <div class="description">
                    <h2>Enviado</h2>
                    <h4>15/05/2022 • 08h40</h4>
                </div>
            </div>
            <div class="item">
                <div class="circle">
                    <i class="bi bi-box-seam">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
                            <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
                          </svg>
                    </i>
                </div>
                <div class="description">
                    <h2>Entregue</h2>
                    <h4>20/05/2022 • 14h17</h4>
                </div>
            </div>
                </div>
        </div>

    <footer class="footer"></footer>
</body>
</html>
