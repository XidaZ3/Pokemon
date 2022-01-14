<?php
    session_start();
    require_once "db.php";
    use DB\DBAccess;
    $db = new DBAccess();
    $id = isset($_POST['id']) && is_numeric($_POST['id']) ? $_POST['id'] : null;
    $psw = isset($_POST['password']) && is_string($_POST['password']) ? $_POST['password']: null;
    print_r($_POST);
    if(isset($id) && isset($psw)){
        $db->openDBConnection();
        $user = $db->getUserById($id);
        if(isset($user) && password_verify($psw,$user['password'])){
            $db->disableUser($id);
            session_unset();
            session_destroy();
        }
        $db->closeDBConnection();
    }
    
?>