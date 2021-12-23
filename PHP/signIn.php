<?php

    session_start(); //Attivo la session per accedere alla variabile $_SESSION[]
    require_once "db.php";
    use DB\DBAccess;
    $db= new DBAccess();
    $userAdded= false;
    $userFound= false;
    $usedEmail= null;
    $usedUsername = null;
    $errorEmail=false;
    $errorUsername = false;
    if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['uname'])) // Verifico che siano state inviate le variabili necessarie
    {
        $email = $_POST['email'];
        $psw = $_POST['password'];
        $uname = $_POST['uname'];
        $db->openDBConnection();
         // Verifico se trovo già entries con questa email o username
        $u = $db->getUserByUsername($uname);
        $e = $db->getUserByEmail($email);
        $errorEmail = isset($e) ? true : false;
        $errorUsername = isset($u) ? true : false;
        if(is_null($msgEmail) && is_null($msgUsername)){
            //Email e username sono originali quindi procedo all'inserimento e il successivo richiamo delle informazioni
            $result = $db->addUser($email, $psw, $uname);
            $user = $result ? $db->getUser($email, $psw) : null;
            $userAdded = $result;
            $db->closeDBConnection(); 
            if (!is_null($user) && is_array($user))  {
                //Se è stato possibile ritrovare l'utente aggiungo il suo id alla sessione
                $_SESSION['userid']=$user['id'];
                $_SESSION['privilegio']=$user['privilegio'];
                $userAdded= true;
                $userFound=true;
            }else if(!is_null($user) && !is_array($user)) {
                //L'utente è stato inserito ma non sono riuscito a recuperare i suoi dati
                $userFound=false;
                $userAdded= true;
            }
        }
    }
    if($userAdded && $userFound)
        header("Location: profilo.php");
    else if($userAdded && !$userFound){
        $_SESSION['msg']['userAdded']=$userAdded;
        $_SESSION['msg']['userFound']=$userFound;
        header("Location: registrazione.php");
    }else if(!$userAdded){
        $_SESSION['msg']['errorEmail']=$errorEmail;
        $_SESSION['msg']['errorUsername']=$errorUsername;
        $_SESSION['msg']['usedEmail']=$email;
        $_SESSION['msg']['usedUsername']=$uname;
        header("Location: registrazione.php");
    }

    
?>