<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Luz da Vida</title>
    <link rel="stylesheet" href="../estilos/ongs.css">
    <!-- Ícones da página -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
    <!----------------------------------------------------------------------------------------------------------->

    <header class="header">
            <!--Menu superior -->
            <div class="menu-sup">
                <nav class="nav">
                    <a class="inativo" href="../home.php" >HOME</a>
                    <a class="ativo">ONG</a>
<?php
                if((isset($_SESSION['email']) == true) and (isset($_SESSION['senha']) == true)){
                    echo "<a class='inativo' href='../Rastreio/rastreio.php'>RASTREIO</a>";
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
                    echo "<a href='../login.php'>Login</a>";
                    echo "<a href='../cadastro/cadastro.php'>Cadastre-se</a>";
                }
                else{
                    echo "<div class='div-sair'><a class='btn-sair' href='../sair.php'>Sair</a></div>";
                }
?>
                </nav>
            </div>
        </header>

        <div class="container">
            <div class="ong">
                <h1>Ong Luz da Vida</h1>
                <div></div>
                <p>No mundo atual muitas crianças acabam não frequentando a escola ou por falta de condições ou por terem seus direitos violados. Nossa organização por meio de doações irá ajudar e acolher crianças que não tem condições a frequentarem uma boa escola e adquirir seus direitos de volta. </h3>
            </div>
        
            <div class="ong2">
                <div class="doar">
                    <h2>Deseja nos apoiar?</h2>
                    <a href="../pagamentos.php" target="_blank">Clique aqui para doar</a>
                </div>
                <div class="apoio">
                    <h2>Deseja ser voluntário?</h1>
                    <p>Entre em contato com a nossa Ong, email: <b>contato@threehugs.com</b></p>
                </div>
            </div>
        </div>

        <footer class="footer"></footer>

</body>
</html>