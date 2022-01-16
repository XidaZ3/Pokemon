<?php
    session_start();
    require_once "db.php";
    use DB\DBAccess;
    $db= new DBAccess();
    //Raccolgo le informazioni necessarie ad individuare l'entry
    $userid= isset($_SESSION['userid']) ? $_SESSION['userid'] : null;
    $comment = isset($_POST['commentid']) ? $_POST['commentid'] : null;

    $db->openDBConnection();

    if(isset($comment) && isset($userid))
    {
        //Il commentid è una stringa le cui prime due lettere non sono caratteri numerici, mentre le successive sono le effetive cifre dell'id
        $comment=substr($comment,2);
        $db->deleteComment($comment);
    }
    $db->closeDBConnection();
?>