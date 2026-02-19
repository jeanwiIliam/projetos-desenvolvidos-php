<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/pagamentos copy.css">


        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <title>Pagamentos</title>
</head>
<body>

    <div id="borda"></div>

    <div class="transf1">
        <br>
        <img width="150px" height="150px" id="logo_credit" src="Credit-card.png" alt="">
        <br>
        <p style="text-align: center;">Transferência via DOC, TED ou depósito bancário</p>

<!--********************************************************************************************-->

<a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-dados">Ver dados</a>

<div class="modal fade" id="modal-dados" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    
  <div class="modal-dialog" role="document">

      <div class="modal-content">
        <div class="modal-header text-white">
          <h4 class="modal-title">Dados Bancários</h4>
        </div>

        <div class="modal-body">
          <h5> DOC: </h5>
          <h5> DOC: </h5>
          <h5> DOC: </h5>
        </div>

        <div class="modal-footer">
            <a th:href="@{/deletarAluno(id=${aluno.id})}"> <button type="button" class="btn btn-danger" id="button-excluirmodal">Sim</button></a>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
        </div>
      </div>

  </div>

</div> 



<!--********************************************************************************************-->
    </div>

    <div class="transf2">
        <br>
        <img width="200px" height="100px" id="logo_pix" src="logo_pix.png" alt="">
        <br>
        <p style="text-align: center;">Transferência via Pix</p>
<!--*********************************************************************************************************-->
<a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-dados2">Ver dados</a>

<div class="modal fade" id="modal-dados2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    
  <div class="modal-dialog" role="document">

      <div class="modal-content">
        <div class="modal-header text-white">
          <h4 class="modal-title">Dados Pix</h4>
        </div>

        <div class="modal-body">
          <h5> Chave Pix:  </h5>

        </div>

        <div class="modal-footer">
            <a th:href="@{/deletarAluno(id=${aluno.id})}"> <button type="button" class="btn btn-danger" id="button-excluirmodal">Sim</button></a>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
        </div>
      </div>

  </div>

</div>        
<!--*********************************************************************************************************-->    
</div>

    <div class="transf3">
        <br>
        <img width="150px" height="150px" id="logo_alimentos" src="alimentos.png" alt="">
        <br>
        <p style="text-align: center;">Doação de alimentos não-perecíveis</p>
<!--*********************************************************************************************************-->
<a href="#" class="button" data-bs-toggle="modal" data-bs-target="#modal-dados3">Ver dados</a>

<div class="modal fade" style="margin-top: 200px;" id="modal-dados3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    
  <div class="modal-dialog" role="document">

      <div class="modal-content">
        <div class="modal-header text-white">
          <h4 class="modal-title">Alimentos Perecíveis</h4>
        </div>

        <div class="modal-body">
          <h5>Quais alimentos são permitidos doar?</h5>
          <ul>
              <li>Arroz</li>
          </ul>
          

        </div>

        <div class="modal-footer">
            <a th:href="@{/deletarAluno(id=${aluno.id})}"> <button type="button" class="btn btn-danger" id="button-excluirmodal">Sim</button></a>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
        </div>
      </div>

  </div>

</div>        
<!--*********************************************************************************************************-->
    </div>

    <div class="transf4">
        <img  id="logo_upload" src="uploadIcon.png" alt="">
        <form class="form" action="comprovantes.php" method="post" enctype="multipart/form-data">
            <h2 style="margin-top: -1%;">Upload de comprovantes</h2>
            <input type="file" name="upload_file" placeholder="Selecione um arquivo...">
        </form>
    </div>

    <div class="transf5">
        <p>Listagem dos comprovantes enviados</p>
        <table>
            <tr>
                <th>Comprovantes</th>
            </tr>
            <tr>
                <th></th>
            </tr>
        </table>
    </div>
    
    <div id="bordainf" style="width: 1361px;; margin-top: 40px; margin-left:-20px;  position: absolute;"></div>
</body>
</html>

<?php
?>