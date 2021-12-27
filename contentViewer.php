<?php
    session_start();
    require_once "PHP/db.php";
    use DB\DBAccess;
    $db = new DBAccess();
    $paginaContentViewer = file_get_contents('visualizzazione_contenuti.html');
    $guida = isset($_GET['guida']) ? $_GET['guida'] : null;
    $articolo = isset($_GET['articolo']) ? $_GET['articolo'] : null;
    $titolo = isset($_GET['titolo']) ? $_GET['titolo']: null;
    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : -1;
    if($id == -1){
        header("Location: 404.html");
        return;
    }
    $_SESSION['id']=$id;

    $db->openDBConnection();
    $content = "";
    if(isset($guida) && isset($titolo)){
        $content = file_get_contents('Guide/'.$guida.'/index.html');
        $content = str_replace('img/', "Guide/".$guida."/img\/", $content);
    }else if(isset($articolo) && isset($titolo)){
        $content = file_get_contents('Articoli/'.$articolo.'/index.html');
        $content = str_replace('img/', "Articoli/".$articolo."/img\/", $content);
    }else{
        $paginaContentViewer = file_get_contents('../404.html');
        return;
    }
    $paginaContentViewer = str_replace('<content/>', $content, $paginaContentViewer);
    $paginaContentViewer = str_replace('<title/>', $titolo, $paginaContentViewer);
    $userid = isset($_SESSION['userid'])? $_SESSION['userid'] : 0;
    $comments = $db->getContentComments($id,$userid);
    $commentOutput="";
    if(isset($comments)){
        foreach($comments as $item){
            $karmaClass = $item['valore'] == 1 ? 1: ($item['valore'] == -1 ? 0 : null);
            $commentOutput = $commentOutput. "<div class=\"boxRect hflex\">
                                                <div class=\"avatarBox vflex\">
                                                    <div class=\"avatar\"></div>
                                                    <label for=\"username\">{$item['username']}</label>
                                                </div>
                                                <div class=\"commento vflex\">
                                                    <p class=\"testo\">{$item['testo']}</p>
                                                    <div class=\"gestioneCommento hflex\">
                                                    <button class=\"like".(isset($karmaClass) && $karmaClass ? " pressed" : " unpressed")."\">Like</button>
                                                    <button class=\"dislike".(isset($karmaClass) && !$karmaClass ? " pressed" : " unpressed")."\">Dislike</button>
                                                    ".($userid == $item['userid'] ? "<button id=\"cancella\">Cancella</button>" : "")."
                                                    <p class=\"dataCreazione\">{$item['timestamp']}</p>
                                                    </div>
                                                </div>
                                            </div>";
        }
    }
    $paginaContentViewer = str_replace('<commenti/>', $commentOutput, $paginaContentViewer);
    echo $paginaContentViewer;
?>