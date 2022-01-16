<?php
    session_start();
    require_once "db.php";
    use DB\DBAccess;
    $db = new DBAccess();
    $paginaLogIn = file_get_contents('../logInPage.html');
    //Eventuali messaggi di errore possono essere ad esempio il fatto che non è presente nessun account con le credenziali specificate
    if(isset($_SESSION['msg']['loginError']) && $_SESSION['msg']['loginError']){
        $paginaLogIn = str_replace('<loginError/>', 'Nessun utente con questo username e password', $paginaLogIn);
        $paginaLogIn = str_replace('<username/>',$_SESSION['msg']['usedUsername'],$paginaLogIn);
    }   
    else{
        $paginaLogIn = str_replace('<loginError/>', '', $paginaLogIn);
        $paginaLogIn = str_replace('<username/>','',$paginaLogIn);
    }
    echo $paginaLogIn;

?>