<?php
    session_start();
    require_once "db.php";
    use DB\DBAccess;
    $paginaRegistrazione = file_get_contents('../registrazione.html');
    //Recupero i messaggi di errore che potrebbero o meno essere stati generati in una immediatamente precedente visita della pagina
    $errorEmail = isset($_SESSION['msg']['errorEmail']) && is_bool($_SESSION['msg']['errorEmail']) ? $_SESSION['msg']['errorEmail'] : null; //Se $_SESSION['msg']['email'] è string significa che ha causato problemi
    $errorUsername = isset($_SESSION['msg']['errorUsername']) && is_bool($_SESSION['msg']['errorUsername']) ? $_SESSION['msg']['errorUsername'] : null;
    $userAdded = isset($_SESSION['msg']['userAdded']) && is_bool($_SESSION['msg']['userAdded']) ? $_SESSION['msg']['userAdded'] : null;
    $userFound = isset($_SESSION['msg']['userFound']) && is_bool($_SESSION['msg']['userFound']) ? $_SESSION['msg']['userFound'] : null;
    //Per tutti gli if/else statemente sotto vengono iniettati dei messaggi di errore se necessari
    if(isset($errorEmail) && $errorEmail) $paginaRegistrazione = str_replace('<emailError/>','Questa email è già utilizzata', $paginaRegistrazione);
    else                                  $paginaRegistrazione = str_replace('<emailError/>','', $paginaRegistrazione);
    
    if(isset($errorUsername) && $errorUsername) $paginaRegistrazione = str_replace('<usernameError/>','Questo username è già utilizzato', $paginaRegistrazione);
    else                                        $paginaRegistrazione = str_replace('<usernameError/>','', $paginaRegistrazione);
    
    if(isset($_SESSION['msg']['usedEmail']) && isset($_SESSION['msg']['usedUsername'])){
        $paginaRegistrazione = str_replace('<email/>', $_SESSION['msg']['usedEmail'], $paginaRegistrazione);
        $paginaRegistrazione = str_replace('<uname/>', $_SESSION['msg']['usedUsername'], $paginaRegistrazione);
    }else{
        $paginaRegistrazione = str_replace('<email/>', '', $paginaRegistrazione);
        $paginaRegistrazione = str_replace('<uname/>', '', $paginaRegistrazione);
    }

    if(isset($errorEmail) && !$errorEmail && isset($errorUsername) && !$errorUsername){
        //Non ci sono stati errori nè di email nè di username duplicati
        if(isset($_SESSION['msg']['userFound']) && !$_SESSION['msg']['userFound']){
            //L'utente è stato inserito ma c'è stato un errore nella query per richiamare l'id autogenerato da inserire nella sessione
            $paginaRegistrazione = str_replace('<div id="cuserfound"></div>', '<div id="cuserfound" class="errormsg"> Profilo creato con successo, ma c\'è stato un errore nel caricarlo. Ricarica. </div>', $paginaRegistrazione);
        }
        $paginaRegistrazione = str_replace('<email/>', '', $paginaRegistrazione);
        $paginaRegistrazione = str_replace('<emailError/>','', $paginaRegistrazione);
        $paginaRegistrazione = str_replace('<uname/>', '', $paginaRegistrazione);
        $paginaRegistrazione = str_replace('<usernameError/>','', $paginaRegistrazione);
    }
    echo $paginaRegistrazione;
    
?>