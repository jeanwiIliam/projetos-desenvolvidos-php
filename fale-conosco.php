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
    <link rel="stylesheet" href="estilos/fale-conosco.css">
    <!-- Ícones da página -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>

<body>
    <header class="header">
        <!--Menu superior -->
        <div class="menu-sup">
            <nav class="nav">
                <a class="inativo" href="home.php">HOME</a>
                <a class="inativo" href="Ong.php">ONG</a>
<?php
            if((isset($_SESSION['email']) == true) and (isset($_SESSION['senha']) == true)){
                echo "<a class='inativo' href='Rastreio/rastreio.php'>RASTREIO</a>";
            }
?>
                <a class="ativo">FALE CONOSCO</a>
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
        <div class="tittle">
            <h1>Fale Conosco - Three Hugs</h1>
        </div>
        <div class="content">
            <div class="faleco">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                    <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                </svg>
                <p>contato@threehugs.com</p>
            </div>
            <div class="faleco">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                </svg>
                <p>(92) 99999-9999</p>
            </div>
            <div class="faleco">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                </svg>
                <p>Av. Paraíso das Flores, 121</p>
            </div>
        </div>
    </div>

    <footer class="footer"></footer>
    
</body>
</html>