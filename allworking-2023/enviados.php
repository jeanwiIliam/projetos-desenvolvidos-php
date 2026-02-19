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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/home.css">
    <script src="js/theme.js" defer></script>
    <title>Enviados</title>

    <style>

        h4{
            font-size: 16px;
            font-weight: bold;
        }

        .sair{
            padding: 5px 10px;
        }
        .sair:hover{
            padding: 5px 10px;
        }

        .container{
            background-color: rgb(149, 152, 165);
            padding-top: 5px;
            width: 70%;
        }

        table a{
            text-decoration: none;
        }

        .trash{
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bxs-trash{
            background-color: brown;
            color: white;
            display: flex;
            align-items:center;
            justify-content:center;
            height: 30px;
            width: 30px;
            text-align: center;
            border-radius: 3px;
        }

        footer, ul, li, i{
            padding:0;
            margin:0;
        }

        footer i{
            margin-top: 25px;
        }

        footer p{
            margin-top: 0;
        }

        .dark header .header3 .sair:hover{
            padding: 5px 10px;
        }

        .dark .container{
            background-color: rgb(20, 20, 20);
        }

        .dark .container .table td{
            color: white;
            background-color: rgb(26, 26, 26);
        }
        .dark .container .table th{
            color: white;
            background-color: rgb(15, 15, 15);

        }
    </style>

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
            <div class='enviados'>
                <a class='hov' href='enviados.php'>Enviados</a>
            </div>


        </div>

        <div class="header3">


<?php

                    include_once('php/conexao.php');
                    $email = $_SESSION['email'];
                    $senha = $_SESSION['senha'];
                    $sql = "SELECT * FROM usuario WHERE email = '$email' and senha = '$senha'";
                    $res = $con->query($sql);
                    if($res->num_rows > 0)
                    {
                        while($reg = mysqli_fetch_assoc($res))
                        {
                            $nome = $reg['nome'];
                            $cpf_usuario = $reg['cpf'];
                        }
                    }
                    $aux = explode(" ",$nome);


                    echo "<h4 class='nome' style='margin:0;'>Olá, "."$aux[0]</h4>";
                    echo "<a class='sair' href='php/sair.php'>Sair</a>";

                    $sqlCurriculo = "SELECT * FROM curriculo WHERE cpf_usuario = '$cpf_usuario' ";
                    $resCurriculo = $con->query($sqlCurriculo);

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
            <table class="table table-light text-center table-bg">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Empresa</th>
                        <th scope="col">Vaga</th>
                        <th scope="col">Apagar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while($regCurriculo = mysqli_fetch_assoc($resCurriculo)) {
                            echo "<tr>";
            
                            echo "<td><a href='curriculos/".$regCurriculo['nome']."' target='_blank'>".$regCurriculo['nome']."</a></td>";
                            echo "<td>Deficiência ".$regCurriculo['categoria']."</td>";
                            echo "<td>".$regCurriculo['empresa']."</td>";
                            echo "<td>".$regCurriculo['vaga']."</td>";
                            echo "<td class='trash'><a href='php/deleteCurriculo.php?id=$regCurriculo[nome]'><i style='font-size:16px' class='bx bxs-trash' ></i></a></td>";

                            echo "</tr>";
                        }
                        ?>
                </tbody>
            </table>
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