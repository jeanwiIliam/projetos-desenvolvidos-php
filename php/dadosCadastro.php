<?php

    date_default_timezone_set('America/Manaus');

    include_once('conexao.php');
    

    if(isset($_POST['salvar'])){


        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $rg = $_POST['rg'];
        $data_nasc = $_POST['date'];
        $telefone = $_POST['telefone'];
        $genero = $_POST['genero'];
        $estado = $_POST['estado'];
        $cidade = $_POST['cidade'];
        $cep = $_POST['cep'];
        $bairro = $_POST['bairro'];
        $rua = $_POST['rua'];
        $numero = $_POST['numero'];
        $complemento = $_POST['complemento'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        /*print_r('Nome: ' . $nome); print_r('<br>');
        print_r('CPF: ' . $cpf); print_r('<br>');
        print_r('RG: ' . $rg); print_r('<br>');
        print_r('Data Nasc: ' . $data_nasc); print_r('<br>');
        print_r('Genero: ' . $genero); print_r('<br>');
        print_r('Estado: ' . $estado); print_r('<br>');
        print_r('telefone: ' . $telefone); print_r('<br>');
        print_r('cidade: ' . $cidade); print_r('<br>');
        print_r('bairro: ' . $bairro); print_r('<br>');
        print_r('rua: ' . $rua); print_r('<br>');
        print_r('num: ' . $numero); print_r('<br>');
        print_r('complem: ' . $complemento); print_r('<br>');
        print_r('email: ' . $email); print_r('<br>');
        print_r('senha: ' . $senha); print_r('<br>');*/


        $query = mysqli_query($con, "INSERT INTO cliente (nome, cpf, telefone, rg, datanascimento, genero, estado, cidade, cep, bairro, rua, num, complemento, email, senha) VALUES ('$nome', '$cpf', '$telefone', '$rg', '$data_nasc', '$genero', '$estado', '$cidade', '$cep', '$bairro', '$rua', '$numero', '$complemento', '$email', '$senha')");
        
        if($query){
            header('location: ../login.php');    
        }else{
            echo "Deu merda";
        }
    }
?>