<?php
    session_start();
    require_once "db.php";
    use DB\DBAccess;
    $db= new DBAccess();

    $userid= isset($_SESSION['userid']) ? $_SESSION['userid'] : null;
    $id= isset($_SESSION['id']) ? $_SESSION['id'] : null;
    $comment = isset($_POST['comment']) ? $_POST['comment'] : null;
    $res = null;

    $db->openDBConnection();
    
    error_log($id);
    error_log($userid);
    error_log($comment);

    if(isset($id))
    {
        $res=$db->addComment($userid, $comment, $id);
        $arrayitem = $db->getContentComments($id,$userid);
        $item = end($arrayitem);

        $db->closeDBConnection();

        $karmaClass = $item['valore'] == 1 ? 1: ($item['valore'] == -1 ? 0 : null);
        $output =   "<div id=\"nc{$item['commentoid']}\" class=\"boxRect hflex\">
        <div class=\"avatarBox vflex\">
            <div class=\"avatar\"></div>
            <label for=\"username\">{$item['username']}</label>
        </div>
        <div class=\"commento vflex\">
            <p class=\"testo\">{$item['testo']}</p>
            <div class=\"gestioneCommento hflex\">
            <button onclick=\"likeComment()\" class=\"like".(isset($karmaClass) && $karmaClass ? " pressed" : " unpressed")."\">Like</button>
            <button onclick=\"dislikeComment()\" class=\"dislike".(isset($karmaClass) && !$karmaClass ? " pressed" : " unpressed")."\">Dislike</button>
            ".($userid == $item['userid'] ? "<button id=\"cancella\">Cancella</button>" : "")."
            <p class=\"dataCreazione\">{$item['timestamp']}</p>
            </div>
        </div>";
        echo $output;
    }
    if(!$res)
        error_log("errore inserimento commento");

    function pulisciInput($value){
        $value = trim($value);
        $value = htmlentities($value);
        $value = htmlspecialchars($value);
        return $value;
    }

?>