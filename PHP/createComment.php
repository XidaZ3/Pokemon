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
    
    if(!isset($userid))
    {
        echo -1;
        return;
    }

    if(isset($id) && isset($comment))
    {
        $res=$db->addComment($userid, $comment, $id);
        $arrayitem = $db->getContentComments($id,$userid);
        $item = reset($arrayitem);

        $db->closeDBConnection();

        $karmaClass = $item['valore'] == 1 ? 1: ($item['valore'] == -1 ? 0 : null);
        $output =   "<div id=\"nc{$item['commentoid']}\" class=\"boxRect hflex\">
        <div class=\"avatarBox vflex\">
            <img class=\"avatar\" src=\"../Immagini/emerald/{$item['avatar']}.png\">
            <label for=\"username\">{$item['username']}</label>
        </div>
        <div class=\"commento vflex\">
            <button onclick=\"deleteComment()\" class=\"cancella\">Cancella</button>
            <p class=\"testo\">{$item['testo']}</p>
            <div class=\"gestioneCommento hflex\">
            <button onclick=\"likeComment()\" class=\"like".(isset($karmaClass) && $karmaClass ? " pressed" : " unpressed")."\">Like</button>
            <button onclick=\"dislikeComment()\" class=\"dislike".(isset($karmaClass) && !$karmaClass ? " pressed" : " unpressed")."\">Dislike</button>
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