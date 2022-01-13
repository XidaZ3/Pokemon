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
            $_SESSION['msg']['loginError']=true;
            $_SESSION['msg']['usedUsername']=$username;
        }else {
            $_SESSION['userid']= $user['id'];
            $_SESSION['privilegio']=$user['privilegio'];
            if($user['privilegio'] == "1") {
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