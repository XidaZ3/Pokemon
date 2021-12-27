<?php
    session_start();
    require_once "db.php";
    use DB\DBAccess;
    $db= new DBAccess();

    $user= isset($_SESSION['userid']) ? $_SESSION['userid'] : null;
    $id= isset($_SESSION['id']) ? $_SESSION['id'] : null;
    $comment = isset($_POST['comment']) ? $_POST['comment'] : null;
    $res = null;

    $db->openDBConnection();
    
    error_log($id);
    error_log($user);
    error_log($comment);

    if(isset($id))
        $res=$db->addComment($user, $comment, $id);

    if(!$res)
        error_log("errore inserimento commento");
    $db->closeDBConnection();


    function pulisciInput($value){
        $value = trim($value);
        $value = htmlentities($value);
        $value = htmlspecialchars($value);
        return $value;
    }

?>