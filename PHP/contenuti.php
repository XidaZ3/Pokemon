<?php 
    session_start();
    require_once "db.php";
    use DB\DBAccess;
    $db = new DBAccess();
    $db->openDBConnection();
    $paginaContenuti = file_get_contents('../contenuti.html');
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 0;
    $guides = $db->getGuideContents($page);
    print($page);
    print_r(gettype($guides));
    $db->closeDBConnection();
    if(isset($guides)){
        $output = "";
        if(isset($guides) && is_array($guides)){
            foreach($guides as $item){
                $output = $output . "<li class=\"guida\"><a href=\"../Uploads/{$item['path']}/index.html\">{$item['path']}</a></li>";
            }
        }
        $paginaContenuti = str_replace('<guide/>', $output, $paginaContenuti);
    
    }
    echo $paginaContenuti;
    
?>