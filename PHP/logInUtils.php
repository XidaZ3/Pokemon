<?php
    session_start();
    require_once "db.php";
    use DB\DBAccess;
    $db= new DBAccess();
    $db->openDBConnection();
    if(isset($_POST['email']) && isset($_POST['password'])){
        $email = pulisciInput($_POST['email']);
        $psw =$_POST['password'];
        $user = $db->getUser($email, $psw);
        $db->closeDBConnection();
        if(!isset($user)){
            $_SESSION['msg']['loginError']=true;
            $_SESSION['msg']['usedEmail']=$email;
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