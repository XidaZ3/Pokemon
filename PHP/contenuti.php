<?php 
    session_start();
    require_once "db.php";
    use DB\DBAccess;
    
    $contenutiPerPagina = 5;
    $paginaContenuti = file_get_contents('../contenuti.html');
    //I parametri per la visualizzazione dinamica dei contenuti vengono passati con GET e sono 'page', 'filter' e 'tipo'
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 0;
    $filter = isset($_GET['filter']) && is_numeric($_GET['filter']) ? $_GET['filter'] : "0";
    $contentType = isset($_GET['tipo']) && is_numeric($_GET['tipo']) ? $_GET['tipo'] : 0;
    //Se l'utente che richiede i contenuti è amministratore (privilegio = 1) dovrò anche aggiungere l'opzione di cancellarli
    $privilegio = isset($_SESSION['privilegio']) && is_numeric($_SESSION['privilegio']) ? $_SESSION['privilegio'] : 0;
    $content = getContentByFilter($contentType,$filter,$page);

    $db = new DBAccess();
    $db->openDBConnection();
    //Numero di contenuti disponibili di quella tipologia per il calcolo delle pagine in cui sono divisi
    $numeroContenuti = $db->getContentNumberByType($contentType);
    $db->closeDBConnection();

    if(isset($numeroContenuti) & $numeroContenuti > 0){
        //Creo il navigatore delle pagine
        $pagesLink = ($page == 0 ? "" : "<a href=\"contenuti.php?page=".($page-1)."&filtro={$filter}&tipo={$contentType}\"> &lt;  </a>");
        $pagesLink = $pagesLink . "<p>".($page+1)." di ". (ceil($numeroContenuti[0]['ncontenuti']/$contenutiPerPagina)) ." </p>";
        $pagesLink = $pagesLink. ($page == (ceil($numeroContenuti[0]['ncontenuti']/$contenutiPerPagina)-1) ? "" : "<a href=\"contenuti.php?page=".($page+1)."&filtro={$filter}&tipo={$contentType}\">  &gt; </a>");
        $paginaContenuti = str_replace("<pageLink/>", $pagesLink, $paginaContenuti);
    }
    //Reinserisco il valore del filtro che era precedentemente selezionato (ad esempio se vado alla pagina successiva)
    $optionOutput = "";
    $options = array("Più recenti","Più vecchi","Più votati","Più discussi");
    for($i =0; $i<4; $i++){
        if($i == (int)$filter)
            $optionOutput= $optionOutput."<option value=\"$i\" selected >{$options[$i]}</option>";
        else
            $optionOutput=$optionOutput."<option value=\"$i\" >{$options[$i]}</option>";
    }
    $paginaContenuti = str_replace('<filterOptions/>', $optionOutput, $paginaContenuti);
    //Per il tipo di contenuto nella pagina creo il titolo adatto e il link all'altro tipo
    $link = "";
    $title = "";
    if($contentType){
        $link = "<a href=\"contenuti.php?tipo=0\" tabindex=\"3\">Vai alle guide...</a>";
        $title = "Articoli <img src=\"../Immagini/icons/article.png\" class=\"icon\" alt=\"\"/>";
    }else{
        $link = "<a href=\"contenuti.php?tipo=1\" tabindex=\"3\">Vai agli articoli...</a>";
        $title = "Guide <img src=\"../Immagini/icons/guide-book.png\" class=\"icon\" alt=\"\"/>";
    }
    $paginaContenuti = str_replace('<contentLink/>', $link, $paginaContenuti);
    $paginaContenuti = str_replace('<contentTitle/>', $title, $paginaContenuti);
    //Per ogni contenuto prelevato dal db creo l'elemento della lista con le sue informazioni
    $output = "";
    if(isset($content) && is_array($content)){
        foreach($content as $key => $item){
            $titoloTrim = str_replace(' ', '%20', $item['titolo']);
            
            $output = $output . "<li class=\"hflex itemList\" id=\"$key\">
                                    <a href=\"../contentViewer.php?id={$item['id']}\">{$item['titolo']}</a>
                                    <ul class =\"itemStats\">
                                        <li>Creato:<br/>{$item['data_creazione']}
                                        <li>Karma:". (isset($item['karma']) ? $item['karma'] : 0)."</li>
                                        <li>Commenti:". (isset($item['ncom']) ? $item['ncom'] : 0)."</li>
                                    </ul>
                                    <div class=\"avatarBox vflex\">
                                        <img class=\"avatar miniAvatar\" src=\"../Immagini/emerald/{$item['avatar']}.png\" alt=\"\" />
                                        <span>{$item['editore']}</span>
                                    </div> <div class=\"vflex\">".
                                    ($privilegio == 1 ? "<a class=\"smalltext delete\" href=\"deleteContent.php?id={$item['id']}&path={$item['path']}&tipo={$item['tipo']}\">Elimina Contenuto</a>" : "")
                                ."</div> </li>";
        }
    }
    $paginaContenuti = str_replace('<content/>', $output, $paginaContenuti);
    
    echo $paginaContenuti;
    return;

    //Funzione di utilità per racchiudere le chiamate al db differenziate per tipo di contenuto e opzione di filtro
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