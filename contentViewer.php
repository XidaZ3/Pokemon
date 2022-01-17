<?php
    session_start();
    require_once "PHP/db.php";
    use DB\DBAccess;
    $db = new DBAccess();
    $paginaContentViewer = file_get_contents('visualizzazione_contenuti.html');
    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : -1;
    
    if($id == -1){
        header("Location: errore404.html");
        return;
    }
    $db->openDBConnection();
    $contentCheck = $db->getContentById($id);
    if(isset($contentCheck) && is_array($contentCheck)){
        $_SESSION['id']=$id;
        $description=" <meta name=\"description\" content=\"".$contentCheck['titolo'];
        $titoloPagina= "<title>".$contentCheck['titolo'];
        $content = "";
        if($contentCheck['tipo']==0){
            $content = file_get_contents('Guide/'.$contentCheck['path'].'/index.html');
            $content = str_replace('img/', "Guide/".$contentCheck['path']."/"."img/", $content);
            $description =  $description." - Guide - Pokèfriends\">";
            $titoloPagina= $titoloPagina." - Guide - Pokèfriends </title>";
            
        }else if($contentCheck['tipo']==1){
            $content = file_get_contents('Articoli/'.$contentCheck['path'].'/index.html');
            $content = str_replace('img/', "Articoli/".$contentCheck['path']."/"."img/", $content);
            $description= $description." - Articolo - Pokèfriends\">";
            $titoloPagina=$titoloPagina." - Articolo- Pokèfriends </title>";
        }else{
            header("Location: errore404.html");
            return;
        }
        $paginaContentViewer = str_replace("<tipo/>", $contentCheck['tipo'], $paginaContentViewer);
        $paginaContentViewer = str_replace('<content/>', $content, $paginaContentViewer);
        $userid = isset($_SESSION['userid'])? $_SESSION['userid'] : 0;
        $paginaContentViewer = str_replace('<description/>', $description, $paginaContentViewer);
        $paginaContentViewer = str_replace('<title/>', $contentCheck['titolo'], $paginaContentViewer);
        $paginaContentViewer = str_replace('<PokeFriendsTitolo/>', $titoloPagina, $paginaContentViewer);

        

        if($userid != 0){
            $arrayres= $db->getUserOpinionContent($id,$userid);
            $karma = $db->getContentKarma($id);
            $row = $arrayres->fetch_assoc();
            if($row)
                $karmaContent = $row['valore'] == 1 ? 1: ($row['valore'] == -1 ? 0 : null);
            else
                $karmaContent = null;
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
    }else{
        header("Location: errore404.html");
        return;
    }
    
?>