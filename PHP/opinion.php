<?php
    session_start();
    require_once "db.php";
    use DB\DBAccess;
    $db= new DBAccess();
    //Raccolgo le informazioni necessarie ad individuare il commento e l'utente 
    $opinion= isset($_POST['opinion']) ? $_POST['opinion'] : null;
    $commentid= isset($_POST['commentid']) ? $_POST['commentid'] : null;
    $user= isset($_SESSION['userid']) ? $_SESSION['userid'] : null;
    $db->openDBConnection();

    if(isset($commentid) && isset($user) && isset($opinion))
    {
        //Il contenuto di commentid è una stringa i cui primi due carateri sono lettere e tutto il seguito sono effettivamente le cifre dell'id
        $commentid=substr($commentid,2);
        $res=$db->addCommentOpinion($commentid,$user,$opinion);
    }
    $db->closeDBConnection();
?>