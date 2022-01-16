<?php
    
    session_start();
    $paginaAmministratore = file_get_contents('../amministratore.html');
    //Se la variabile è settata allora prevedo la costruzione di una serie di tag b per la visualizzazione dei messaggi necessari
    if(isset($_SESSION['uploadError']) && is_array($_SESSION['uploadError'])){
        $error = $_SESSION['uploadError'];
        $output ="<b>";
        foreach($error as $message){
            $output = $output."{$message}<br />";
        }
        $output = $output."</b>";
        $paginaAmministratore = str_replace('<div id="output"></div>',$output,$paginaAmministratore);
    }
    echo $paginaAmministratore;
    $_SESSION['uploadError']="";
?>