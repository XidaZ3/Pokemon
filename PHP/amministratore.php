<?php
    session_start();
    require_once "db.php";
    $paginaAmministratore = file_get_contents('../amministratore.html');
    if(isset($_SESSION['uploadError']) && is_array($_SESSION['uploadError'])){
        $error = $_SESSION['uploadError'];
        $output ="";
        foreach($error as $message){
            $output = $output."<li><b>{$message}</b></li>";
        }
        $paginaAmministratore = str_replace('<output/>',$output,$paginaAmministratore);
    }
    echo $paginaAmministratore;
?>