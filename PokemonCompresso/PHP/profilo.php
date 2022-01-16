<?php
    //Questo file serve come punto di snodo per reindirizzare l'utente alla pagina del login se non è già autenticato nella sessione
    //altrimenti alla sua pagina profilo personale
    session_start();
    if(isset($_SESSION['userid']) && isset($_SESSION['privilegio'])){
        header("Location: loggedIn.php");
    }else{
        header("Location: logInPage.php");
    }
?>