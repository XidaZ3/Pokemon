<?php 
    session_start();
    require_once "db.php";
    use DB\DBAccess;
    $contenutiPerPagina = 5;
    $paginaContenuti = file_get_contents('../contenuti.html');
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 0;
    $filter = isset($_GET['filter']) && is_numeric($_GET['filter']) ? $_GET['filter'] : "0";
    $contentType = isset($_GET['tipo']) && is_numeric($_GET['tipo']) ? $_GET['tipo'] : 0;
    $privilegio = isset($_SESSION['privilegio']) && is_numeric($_SESSION['privilegio']) ? $_SESSION['privilegio'] : 0;
    $content = getContentByFilter($contentType,$filter,$page);
    $db = new DBAccess();
    $db->openDBConnection();
    $numeroContenuti = $db->getContentNumberByType($contentType);
    $db->closeDBConnection();
    if(isset($numeroContenuti)){
        $pagesLink = ($page == 0 ? "" : "<a href=\"contenuti.php?page=".($page-1)."&filtro={$filter}&tipo={$contentType}\"> &lt </a>");
        $pagesLink = $pagesLink . "<p>".($page+1)." di ". (round($numeroContenuti[0]['ncontenuti']/$contenutiPerPagina)+1) ." </p>";
        $pagesLink = $pagesLink. ($page == (round($numeroContenuti[0]['ncontenuti']/$contenutiPerPagina)) ? "" : "<a href=\"contenuti.php?page=".($page+1)."&filtro={$filter}&tipo={$contentType}\"> &gt </a>");
        $paginaContenuti = str_replace("<pageLink/>", $pagesLink, $paginaContenuti);
    }
    $optionOutput = "";
    $options = array("Più recenti","Più vecchi","Più votati","Più discussi");
    for($i =0; $i<4; $i++){
        if($i == (int)$filter)
            $optionOutput= $optionOutput."<option value=\"$i\" selected >{$options[$i]}</option>";
        else
            $optionOutput=$optionOutput."<option value=\"$i\" >{$options[$i]}</option>";
    }
    $paginaContenuti = str_replace('<filterOptions/>', $optionOutput, $paginaContenuti);
    $link = "";
    $title = "";
    if($contentType){
        $link = "<a href=\"contenuti.php?tipo=0\">Vai alle guide...</a>";
        $title = "Articoli <img src=\"../Immagini/icons/article.png\" class=\"icon\" alt=\"\"/>";
    }else{
        $link = "<a href=\"contenuti.php?tipo=1\">Vai agli articoli...</a>";
        $title = "Guide <img src=\"../Immagini/icons/guide-book.png\" class=\"icon\" alt=\"\"/>";
    }
    $paginaContenuti = str_replace('<contentLink/>', $link, $paginaContenuti);
    $paginaContenuti = str_replace('<contentTitle/>', $title, $paginaContenuti);
    $output = "";
    if(isset($content) && is_array($content)){
        foreach($content as $key => $item){
            $output = $output . "<li class=\"hflex itemList\">
                                    <a href=\"../contentViewer.php?id={$item['id']}&".($contentType? "articolo":"guida")."={$item['path']}&titolo={$item['titolo']}\">{$item['titolo']}</a>
                                    <ul class =\"itemStats\">
                                        <li>Creato:{$item['data_creazione']}</li>
                                        <li>Karma:". (isset($item['karma']) ? $item['karma'] : 0)."</li>
                                        <li>Commenti:". (isset($item['ncom']) ? $item['ncom'] : 0)."</li>
                                    </ul>
                                    <div class=\"avatarBox vflex\">
                                        <div class=\"avatar miniAvatar\"></div>
                                        <label for=\"username\">{$item['editore']}</label>
                                    </div> <div class=\"vflex\">".
                                    ($privilegio == 1 ? "<a class=\"smalltext delete\" href=\"deleteContent.php?id={$item['id']}&path={$item['path']}&tipo={$item['tipo']}\">Elimina Contenuto</a>" : "")
                                ."</div> </li>";
        }
    }
    $paginaContenuti = str_replace('<content/>', $output, $paginaContenuti);
    
    echo $paginaContenuti;
    return;

    function getContentByFilter($type, $filter,$page){
        $db = new DBAccess();
        $db->openDBConnection();
        $result = array();
        switch($filter){
            case "0": $result = $type ?  $db->getArticleContentsMostRecent($page) : $db->getGuideContentsMostRecent($page); break;
            case "1": $result = $type ?  $db->getArticleContentsLeastRecent($page): $db->getGuideContentsLeastRecent($page);break;
            case "2": $result = $type ?  $db->getArticleContentsMostKarma($page): $db->getGuideContentsMostKarma($page);break;
            case "3": $result = $type ?  $db->getArticleContentsMostComments($page): $db->getGuideContentsMostComments($page);break;
            default: $result = $type ?   $db->getArticleContentsMostRecent($page): $db->getGuideContentsMostRecent($page);break;
        }
        $db->closeDBConnection();
        return $result;
    }
    
?>