<?php
    session_start();
    require_once "PHP/db.php";
    use DB\DBAccess;
    $db = new DBAccess();
    $db->openDBConnection();
    $mostRecent = $db->getContentsMostRecent();
    $mostLiked = $db->getContentsMostKarma();
    $db->closeDBConnection();
    $paginaIndex = file_get_contents('index.html');
    $outputRecent = "";
    if(isset($mostRecent) && is_array($mostRecent)){
        foreach($mostRecent as $key => $item){
            $titoloTrim = str_replace(' ', '%20', $item['titolo']);
            $outputRecent = $outputRecent . "<li class=\"hflex itemList\">
                                                <a href=\"contentViewer.php?id={$item['id']}&".($item['tipo']? "articolo":"guida")."={$item['path']}&titolo=$titoloTrim\">{$item['titolo']}</a>
                                                <ul class =\"itemStats\">
                                                    <li>Creato:<br/>{$item['data_creazione']}</li>
                                                    <li>Karma:{$item['karma']}</li>
                                                    <li>Commenti:{$item['ncom']}</li>
                                                </ul>
                                                <div class=\"avatarBox vflex\">
                                                    <img class=\"avatar miniAvatar\" src=\"Immagini/emerald/{$item['avatar']}.png\" alt=\"\" />
                                                    {$item['editore']}
                                                </div>
                                            </li>";
        }
    }

    $outputLiked = "";
    if(isset($mostLiked) && is_array($mostLiked)){
        foreach($mostLiked as $key => $item){
            $titoloTrim = str_replace(' ', '%20', $item['titolo']);
            $outputLiked = $outputLiked . "<li class=\"hflex itemList\">
                                                <a href=\"contentViewer.php?id={$item['id']}&".($item['tipo']? "articolo":"guida")."={$item['path']}&titolo=$titoloTrim\">{$item['titolo']}</a>
                                                <ul class =\"itemStats\">
                                                    <li>Creato:<br/>{$item['data_creazione']}</li>
                                                    <li>Karma:{$item['karma']}</li>
                                                    <li>Commenti:{$item['ncom']}</li>
                                                </ul>
                                                <div class=\"avatarBox vflex\">
                                                    <img class=\"avatar miniAvatar\" src=\"Immagini/emerald/{$item['avatar']}.png\" alt=\"\" />
                                                    {$item['editore']}
                                                </div>
                                            </li>";
        }
    }
    $paginaIndex = str_replace('<mostRecent/>', $outputRecent, $paginaIndex);
    $paginaIndex = str_replace('<mostLiked/>', $outputLiked, $paginaIndex);
    echo $paginaIndex;
?>
