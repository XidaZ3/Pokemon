<?php
    session_start();
    require_once "db.php";
    use DB\DBAccess;
    $db= new DBAccess();

    //Memorizzo i dati necessari ad individuare il contenuto e l'utente nel database dalla POST
    $opinion= isset($_POST['opinion']) ? $_POST['opinion'] : null;
    $contentid= isset($_SESSION['id']) ? $_SESSION['id'] : null;
    $user= isset($_SESSION['userid']) ? $_SESSION['userid'] : null;

    $db->openDBConnection();
    $res = 0;
    
    if(isset($contentid) && isset($user) && isset($opinion))
        $res=$db->addContentOpinion($contentid,$user,$opinion);
    if(!$res)
        error_log("errore votazione likes");
    $db->closeDBConnection();
?>