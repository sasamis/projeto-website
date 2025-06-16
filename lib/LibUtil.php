
<?php


Class LibUtil {

    /*
    A função abaixo usada para impedir que usuários não logados acessem 
    determinadas partes do site, redirecionando-os para a página de login. 
    */

    public static function redirecionar($pagina) {
        echo "<script>location.href='".$pagina."';</script>";
        exit(); #Para a página do script assim que a página é redirecionada
    }
    
    

    /*
    A função abaixo inicia uma sessão caso nenhuma tenha sido iniciada.
    */
    
    public static function comecarSessao() {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
    }
    
    
        
    public static function atrasar($segundos) {
        
        /*
        'ob_end_flush();' essa função PHP descarrega o buffer de saída 
        e envia todo o conteúdo armazenado no buffer 
        de saída (se houver) para o navegador. 
        Isso garante que qualquer saída em buffer 
        seja enviada antes da pausa na execução.
        */
        ob_end_flush();

        /*
        Esta função descarrega qualquer dado que tenha sido armazenado em cache para ser enviado ao cliente
        */
        flush();
        /*
        Suspende a execução do script por um número de segundos
        */
        sleep($segundos);
    }



}
