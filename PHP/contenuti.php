<?php 
    session_start();
    require_once "db.php";
    use DB\DBAccess;
    $db = new DBAccess();
    $db->openDBConnection();
    $paginaContenuti = file_get_contents('../contenuti.html');
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 0;
    $filter = isset($_GET['filter']) && is_string($_GET['filter']) ? $_GET['filter'] : "0";
    switch($filter){
        case "0":$guides = $db->getGuideContentsMostRecent($page);
                 $articles = $db->getArticleContentsMostRecent($page);break;
        case "1":$guides = $db->getGuideContentsLeastRecent($page);
                 $articles = $db->getArticleContentsLeastRecent($page);break;
        case "2":$guides = $db->getGuideContentsMostKarma($page);
                 $articles = $db->getArticleContentsMostKarma($page);break;
        case "3":$guides = $db->getGuideContentsMostComments($page);
                 $articles = $db->getArticleContentsMostComments($page);break;
        default: $guides = $db->getGuideContentsMostRecent($page);
                $articles = $db->getArticleContentsMostRecent($page);break;
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
    $db->closeDBConnection();
    $output = "";
    if(isset($guides) && is_array($guides)){
        foreach($guides as $key => $item){
            $pagina = file_get_contents("../Uploads/Guide/{$item['path']}/index.html");
            $output = $output . "<li class=\"guida\">
                                    <a href=\"contentViewer.php?guida={$item['path']}&titolo={$item['titolo']}\">{$item['titolo']}</a><br/>
                                    <div class=\"hflex1\">
                                    K:". (isset($item['karma']) ? $item['karma'] : 0) ."
                                    D: {$item['data_creazione']}
                                    C: {$item['ncom']}
                                    </div>
                                    
                                </li>";
        }
    }
    $paginaContenuti = str_replace('<guide/>', $output, $paginaContenuti);
    
    $output = "";
    if(isset($articles) && is_array($articles)){
        foreach($articles as $key => $item){
            $pagina = file_get_contents("../Uploads/Articoli/{$item['path']}/index.html");
            $output = $output . "<li class=\"articolo\">
                                    <a href=\"contentViewer.php?articolo={$item['path']}&titolo={$item['titolo']}\">{$item['titolo']}</a><br/>
                                    <div class=\"hflex1\">
                                    K:". (isset($item['karma']) ? $item['karma'] : 0) ."
                                    D: {$item['data_creazione']}
                                    C: {$item['ncom']}
                                    </div>
                                </li>";
        }
    }
    $paginaContenuti = str_replace('<article/>', $output, $paginaContenuti);

    echo $paginaContenuti;

    function str_replace_n($search, $replace, $subject, $occurrence)
    {
        $search = preg_quote($search,'/');
        return preg_replace("/^((?:(?:.*?$search){".--$occurrence."}.*?))$search/", "$1$replace", $subject);
    }
    
?>