<?php
    session_start();
    if(isset($_SESSION['userid']) && isset($_SESSION['privilegio'])){
        header("Location: loggedIn.php");
    }else{
        header("Location: logInPage.php");
    }
?>