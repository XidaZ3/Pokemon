<?php
    session_start();
    require_once "db.php";
    use DB\DBAccess;
    $db= new DBAccess();

    $opinion= isset($_POST['opinion']) ? $_POST['opinion'] : null;
    $commentid= isset($_POST['commentid']) ? $_POST['commentid'] : null;
    $user= isset($_SESSION['userid']) ? $_SESSION['userid'] : null;

    $db->openDBConnection();
    $res = 0;

    if(isset($commentid) && isset($user) && isset($opinion))
        $res=$db->addCommentOpinion($commentid,$user,$opinion);

    if(!$res)
        error_log("errore votazione likes");
    $db->closeDBConnection();
?>