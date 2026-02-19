<?php
    session_start();
    // print_r($_REQUEST);
    if(isset($_POST['logar']))
    {
        // Acessa
        include_once('conexao.php');
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $sql = "SELECT * FROM usuario WHERE email = '$email' and senha = '$senha'";

        $res = $con->query($sql);

        // print_r($sql);
        // print_r($result);

        if(mysqli_num_rows($res) > 0)
        {
            $_SESSION['email'] = $email;
            $_SESSION['senha'] = $senha;
            header('Location: ../home.php');
        }

         else
        {
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            header('Location: ../login.php');
        }
    }
    else
    {
        // Não acessa
        header('Location: ../login.php');
    }
?>