<?php
    session_start();
    require_once "db.php";
    use DB\DBAccess;
    $db= new DBAccess();
    $db->openDBConnection();

    if(isset($_POST['username']) && isset($_POST['password'])){
        $username = pulisciInput($_POST['username']);
        $psw =$_POST['password'];
        $user = $db->getUser($username, $psw);
        $db->closeDBConnection();
        if(!isset($user)){
            //Se l'utente è null non è stato possibile trovare nessuno con quell'username e quella password
            $_SESSION['msg']['loginError']=true;
            $_SESSION['msg']['usedUsername']=$username;
        }else {
            $_SESSION['userid']= $user['id'];
            $_SESSION['privilegio']=$user['privilegio'];
            if($user['privilegio'] == "1") {
                //Se l'utente è un amministratore lo reindirizzo subito alla sua sezione
                header("Location: amministratore.php");
                exit();
            }
        }

            header("Location: profilo.php");
    }
    
    function pulisciInput($value){
        $value = trim($value);
        $value = htmlentities($value);
        $value = htmlspecialchars($value);
        return $value;
    }

?>