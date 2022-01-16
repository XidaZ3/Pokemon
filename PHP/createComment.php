<?php
    session_start();
    require_once "db.php";
    use DB\DBAccess;
    $db= new DBAccess();

    //Recupero le informazioni necessarie ad individuare l'utente, il contenuto a cui viene fatto un commento e il contenuto del commento
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
        //Aggiungo il commento al database e subito dopo richiedo lo stesso contenuto al fine di ottenere l'id autoincrementale
        //generato dal db per poter inserire il commento nella struttura html con un id significativo ed univoco
        $res=$db->addComment($userid, $comment, $id);
        $arrayitem = $db->getContentComments($id,$userid);
        $item = reset($arrayitem);

        $db->closeDBConnection();
        //Procedo a creare l'html per poter inserire il commento
        $karmaClass = $item['valore'] == 1 ? 1: ($item['valore'] == -1 ? 0 : null);
        $output =   "<div id=\"nc{$item['commentoid']}\" class=\"boxRect hflex\">
        <div class=\"avatarBox vflex\">
            <img class=\"avatar\" src=\"Immagini/emerald/{$item['avatar']}.png\">
            <label for=\"username\">{$item['username']}</label>
        </div>
        <div class=\"commento vflex\">
            <button onclick=\"deleteComment()\" class=\"cancella\">Cancella</button>
            <p class=\"testo\">{$item['testo']}</p>
            <div class=\"gestioneCommento hflex\">
            <button onclick=\"likeComment()\" class=\"like".(isset($karmaClass) && $karmaClass ? " pressed" : " unpressed")."\">Like</button>
            <button onclick=\"dislikeComment()\" class=\"dislike".(isset($karmaClass) && !$karmaClass ? " pressed" : " unpressed")."\">Dislike</button>
            <p id=\"karmaco{$item['commentoid']}\" class=\"karma\">0</p>
            <p class=\"dataCreazione\">{$item['timestamp']}</p>
            </div>
        </div>";
        echo $output;
    }else{
        $db->closeDBConnection();
    }
    
    if(!$res)
        error_log("errore inserimento commento");
?>