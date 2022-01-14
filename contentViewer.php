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
        $content = str_replace('img/', "Guide/".$guida."/"."img/", $content);
    }else if(isset($articolo) && isset($titolo)){
        $content = file_get_contents('Articoli/'.$articolo.'/index.html');
        $content = str_replace('img/', "Articoli/".$articolo."/"."img/", $content);
    }else{
        $paginaContentViewer = file_get_contents('../404.html');
        return;
    }
    $paginaContentViewer = str_replace('<content/>', $content, $paginaContentViewer);
    $paginaContentViewer = str_replace('<title/>', $titolo, $paginaContentViewer);
    $userid = isset($_SESSION['userid'])? $_SESSION['userid'] : 0;
    $paginaContentViewer = str_replace('<title/>', $titolo, $paginaContentViewer);

    

    if($userid != 0)
    {
        $arrayres= $db->getUserOpinionContent($id,$userid);
        $karma = $db->getContentKarma($id);
        $row = $arrayres->fetch_assoc();
        $karmaContent = $row['valore'] == 1 ? 1: ($row['valore'] == -1 ? 0 : null);
        $opinionContent="<div id=\"nc{$id}\" class=\"gestioneContenuto hflex\">
        <button onclick=\"likeContenuto()\" class=\"like".(isset($karmaContent) && $karmaContent ? " pressed" : " unpressed")."\">Like</button>
        <button onclick=\"dislikeContenuto()\" class=\"dislike".(isset($karmaContent) && !$karmaContent ? " pressed" : " unpressed")."\">Dislike</button>".
        "<p id=\"kc{$id}\" class=\"karma\">".(isset($karma) ? ($karma > 0 ? "+" : "").$karma : "0")."</p> </div>";
    }
    else
        $opinionContent="";
    $paginaContentViewer = str_replace('<contentOpinion/>', $opinionContent, $paginaContentViewer);

    $comments = $db->getContentComments($id,$userid);
    $commentOutput="";
    if(isset($comments)){
        foreach($comments as $item){
            $karmaClass = $item['valore'] == 1 ? 1: ($item['valore'] == -1 ? 0 : null);
            $commentOutput = $commentOutput. "<div id=\"nc{$item['commentoid']}\" class=\"boxRect hflex\">
                                                <div class=\"avatarBox vflex\">
                                                    <img class=\"avatar\" src=\"Immagini/emerald/{$item['avatar']}.png\" alt=\"\" />
                                                    {$item['username']}
                                                </div>
                                                <div class=\"commento vflex\">
                                                    ".($userid == $item['userid'] ? "<button onclick=\"deleteComment()\" class=\"cancella\">Cancella</button>" : "")."
                                                    <p class=\"testo\">{$item['testo']}</p>
                                                    <div class=\"gestioneCommento hflex\">
                                                    ".($userid != 0 ? "<button onclick=\"likeComment()\" class=\"like".(isset($karmaClass) && $karmaClass ? " pressed" : " unpressed")."\">Like</button>" : "")
                                                    .($userid != 0 ? "<button onclick=\"dislikeComment()\" class=\"dislike".(isset($karmaClass) && !$karmaClass ? " pressed" : " unpressed")."\">Dislike</button>" :"").
                                                    "<p id=\"karmaco{$item['commentoid']}\" class=\"karma\">".($item['karma'] >0 ? "+" : "").$item['karma']."</p>
                                                    <p class=\"dataCreazione\">{$item['timestamp']}</p>
                                                    </div>
                                                </div>
                                            </div>";
        }
    }
    $paginaContentViewer = str_replace('<commenti/>', $commentOutput, $paginaContentViewer);
    echo $paginaContentViewer;
?>