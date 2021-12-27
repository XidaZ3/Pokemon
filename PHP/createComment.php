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
    {
        $res=$db->addComment($user, $comment, $id);
        // $output = $output . "<li class=\"hflex itemList\">
        //                             <a href=\"../contentViewer.php?id={$item['id']}&".($contentType? "articolo":"guida")."={$item['path']}&titolo={$item['titolo']}\">{$item['titolo']}</a>
        //                             <ul class =\"itemStats\">
        //                                 <li>Creato:{$item['data_creazione']}</li>
        //                                 <li>Karma:". (isset($item['karma']) ? $item['karma'] : 0)."</li>
        //                                 <li>Commenti:". (isset($item['ncom']) ? $item['ncom'] : 0)."</li>
        //                             </ul>
        //                             <div class=\"avatarBox vflex\">
        //                                 <div class=\"avatar miniAvatar\"></div>
        //                                 <label for=\"username\">{$item['username']}</label>
        //                             </div>
        //                         </li>";
        // echo output
    }
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