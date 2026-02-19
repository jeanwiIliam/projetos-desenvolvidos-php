<?php
    session_start();

    $arquivo = $_FILES['arquivo'];

    $deficiencia = $_POST['deficiencia'];
    $empresa = $_POST['empresa'];
    $vaga = $_POST['vaga'];
    $cpf = $_POST['cpf'];

    if($arquivo !== null){
        preg_match("/\.(pdf){1}$/i", $arquivo["name"], $ext);

        if($ext == true){
            $nome_arquivo = md5(uniqid(time())).".".$ext[1];

            $caminho_arquivo = "../curriculos/".$nome_arquivo;

            move_uploaded_file($arquivo["tmp_name"], $caminho_arquivo);

            include 'conexao.php';
            $query = mysqli_query($con, "INSERT INTO curriculo (cpf_usuario, nome, categoria, empresa, vaga) values ('$cpf' ,'$nome_arquivo', '$deficiencia', '$empresa', '$vaga')");
        }
    }

    /*********************************/

    if($deficiencia == 'motora'){
        $def = 'm';    
    }
    else if($deficiencia == 'visual'){
        $def = 'v';
    }
    else if($deficiencia == 'auditiva'){
        $def = 'a';
    }


    /*****************************************/

    if($empresa == 'Bradesco'){
        $emp = 'bra';
    }
    else if($empresa == 'Banco do Brasil'){
        $emp = 'bdb';
    }
    else if($empresa == 'Caixa Econômica'){
        $emp = 'cxa';
    }
    else if($empresa == 'Drogasil'){
        $emp = 'dgs';
    }
    else if($empresa == 'Globant'){
        $emp = 'glo';
    }
    else if($empresa == 'Honda'){
        $emp = 'hon';
    }
    else if($empresa == 'Itaú'){
        $emp = 'ita';
    }
    else if($empresa == 'IBM'){
        $emp = 'ibm';
    }
    else if($empresa == 'Localiza'){
        $emp = 'loc';
    }
    else if($empresa == 'Magalu'){
        $emp = 'mag';
    }
    else if($empresa == 'Marisa'){
        $emp = 'mar';
    }
    else if($empresa == 'Natura'){
        $emp = 'nat';
    }
    else if($empresa == 'Raízen'){
        $emp = 'rai';
    }
    else if($empresa == 'Real Bebidas'){
        $emp = 'rea';
    }
    else if($empresa == 'Rede Conecta'){
        $emp = 'rdc';
    }
    else if($empresa == 'Renner'){
        $emp = 'ren';
    }
    else if($empresa == 'Samsung'){
        $emp = 'sam';
    }
    else if($empresa == 'Torra'){
        $emp = 'tor';
    }
    else if($empresa == 'Womp'){
        $emp = 'wom';
    }

    /*****************************************/

    if ($vaga == 'Analista'){
        $vaga = 'ana';
    }
    else if($vaga == 'Analista de sistemas'){
        $vaga = 'ans';
    }
    else if($vaga == 'Aprendiz de RH'){
        $vaga = 'aprh';
    }
    else if($vaga == 'Aprendiz de setor de vendas'){
        $vaga = 'apsv';
    }
    else if($vaga == 'Aprendiz de TI'){
        $vaga = 'apti';
    }
    else if($vaga == 'Atendente'){
        $vaga = 'ate';
    }
    else if($vaga == 'Auxiliar administrativo'){
        $vaga = 'auad';
    }
    else if($vaga == 'Auxiliar de expedição'){
        $vaga = 'auex';
    }
    else if($vaga == 'Auxiliar de produção'){
        $vaga = 'audp';
    }
    else if($vaga == 'Auxiliar de RH'){
        $vaga = 'aurh';
    }
    else if($vaga == 'Auxiliar de setor de manutenção'){
        $vaga = 'ausm';
    }
    else if($vaga == 'Auxiliar de setor elétrico'){
        $vaga = 'ause';
    }
    else if($vaga == 'Auxiliar de setor financeiro'){
        $vaga = 'ausf';
    }
    else if($vaga == 'Auxiliar de suporte online'){
        $vaga = 'auso';
    }
    else if($vaga == 'Caixa'){
        $vaga = 'cai';
    }
    else if($vaga == 'Design web'){
        $vaga = 'dew';
    }
    else if($vaga == 'Fiscal'){
        $vaga = 'fis';
    }
    else if($vaga == 'Linha de produção'){
        $vaga = 'lpr';
    }
    else if($vaga == 'Manobrista'){
        $vaga = 'man';
    }
    else if($vaga == 'Programador web'){
        $vaga = 'prw';
    }
    else if($vaga == 'Recepcionista'){
        $vaga = 'rec';
    }
    else if($vaga == 'Repositor'){
        $vaga = 'rep';
    }
    else if($vaga == 'Setor administrativo'){
        $vaga = 'sea';
    }
    else if($vaga == 'Setor comercial'){
        $vaga = 'sec';
    }
    else if($vaga == 'Setor de vendas'){
        $vaga = 'sev';
    }
    else if($vaga == 'Setor de manutenção'){
        $vaga = 'sem';
    }
    else if($vaga == 'Setor financeiro'){
        $vaga = 'sef';
    }

/****************************************/


    
    if($query){
        $_SESSION['msg'] = "<p style='color: green; text-align: center; height:100%; font-weight: 600;'>Arquivo enviado com suceso</p>";
        header("location: ../enviar-curriculo.php?d=$def&e=$emp&v=$vaga");    
    }else{
        $_SESSION['msg'] = "<p style='color: red; text-align: center; height:100%; font-weight: 600;'>Falha ao enviar</p>";
        echo $def.$emp.$vaga;
        header("location: ../enviar-curriculo.php?d=$def&e=$emp&v=$vaga");   
    }


?>