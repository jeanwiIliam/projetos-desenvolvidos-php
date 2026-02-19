<?php

    if(!empty($_GET['id']))
    {
        include_once('conexao.php');

        $id = $_GET['id'];

        $sql = "SELECT * FROM curriculo WHERE nome='$id'";

        $res = $con->query($sql);

        if($res->num_rows > 0)
        {
            $sqlDel = "DELETE FROM curriculo WHERE nome='$id'";
            $resDelete = $con->query($sqlDel);
        }
    }
    
    header('Location: ../enviados.php');
   
?>