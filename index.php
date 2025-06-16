<?php
include_once 'lib/LibUtil.php'; #Incluindo a biblioteca

/*

Chamada ao método estático redirecionar da classe LibUtil, 
passando 'view/login.php' como argumento. Este método redireciona 
o navegador para a página de login localizada no caminho 'view/login.php'.

*/

LibUtil::redirecionar('view/login.php'); #Acessa o método redirecionar no escopo da classe LibUtil passando o argumento 'view/login.php'