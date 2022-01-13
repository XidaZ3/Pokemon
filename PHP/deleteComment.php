<?php
    session_start();
    require_once "db.php";
    use DB\DBAccess;
    $db= new DBAccess();

    $userid= isset($_SESSION['userid']) ? $_SESSION['userid'] : null;
    $comment = isset($_POST['commentid']) ? $_POST['commentid'] : null;

    $db->openDBConnection();

    if(isset($comment) && isset($userid))
    {
        $comment=substr($comment,2);
        $db->deleteComment($comment);
    }
    $db->closeDBConnection();
?>