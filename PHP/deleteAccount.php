<?php
    session_start();
    require_once "db.php";
    use DB\DBAccess;
    $db = new DBAccess();
    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : null;
    $psw = isset($_GET['password']) && is_string(($_GET['password'])) ? $_GET['password']: null;
    if(isset($id) && isset($psw)){
        $db->openDBConnection();
        $user = $db->getUserById($id);
        if(isset($user) && password_verify($psw,$user['password'])){
            $db->deleteUser($id);
            session_unset();
            
        }
    }
    header("Location: profilo.php");
?>