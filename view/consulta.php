<?php
    include_once '../controller/Controller.php';
    $controller = new Controller();
    $controller->restringirAcessoVisitante();
    $perfil = $controller->consultarPerfil();
?>

 <!DOCTYPE html>
 <html lang="pt-br">

 <head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width" , initial-scale="1.0">
     <link rel="stylesheet" type="text/css" href="../css/style.css">
     <link href="http://fonts.cdnfonts.com/css/low-gun-screen-expanded" rel="stylesheet">
     <title>Consulta</title>
 </head>

 <body>
     <div class="area-cabecalho">
         <div id="area-logo">
         <h1><span class="roxo">S O F T - C O M P</h1>
         </div>

         <div id="area-menu">
            <a href="inicio.php">Início</a> 
            <a href="consulta.php">Consulta</a>  
            <a href="exclusao.php">Exclusão</a>
            <a href="edicao.php">Edição</a>
            <a href="sair.php">Sair</a>  
         </div>
     </div>

     <div class="content">

         <fieldset>
            <legend>
                <h2 class="text">CONSULTAR DADOS CADASTRAIS</h2>
            </legend>
            <p>
                <strong>Nome:</strong>
                <?php echo($perfil['nome'])?>
            </p><br>
            <p>
                <strong>Email:</strong>
                <?php echo($perfil['email'])?>
            </p><br>
            <p>
                <strong>Telefone:</strong>
                <?php echo($perfil['fone'])?>
            </p><br>
            <p>
                <strong>Sexo: </strong>
                <?php echo($perfil['sexo'])?>
            </p><br>
            <p>
                <strong>Nascimento: </strong>
                <?php echo($perfil['nascimento'])?>
            </p><br>
            <p>
                <strong>Estado: </strong>
                <?php echo($perfil['estado'])?>
            </p><br>
            <p>
                <strong>Semestre:</strong>
                <?php echo($perfil['semestre'])?>
            </p><br>
            <p>
                <strong>Informações Adicionais: </strong>
                <?php echo($perfil['descricao'])?>
            </p><br>
         </fieldset>

     </div>
 </body>

 </html>