<?php
    session_start();
    require_once "PHP/db.php";
    use DB\DBAccess;
    $db = new DBAccess();
    $paginaContentViewer = file_get_contents('visualizzazione_contenuti.html');
    $guida = isset($_GET['guida']) ? $_GET['guida'] : null;
    $articolo = isset($_GET['articolo']) ? $_GET['articolo'] : null;
    $titolo = isset($_GET['titolo']) ? $_GET['titolo']: null;
    $db->openDBConnection();
    if(isset($guida) && isset($titolo)){
        $content = file_get_contents('Guide/'.$guida.'/index.html');
        $paginaContentViewer = str_replace('<content/>', $content, $paginaContentViewer);
        $paginaContentViewer = str_replace('<title/>', $titolo, $paginaContentViewer);
        $paginaContentViewer = str_replace('img/', "Guide/".$guida."/img\/", $paginaContentViewer);
    }else if(isset($articolo) && isset($titolo)){
        $content = file_get_contents('Articoli/'.$articolo.'/index.html');
        $paginaContentViewer = str_replace('<content/>', $content, $paginaContentViewer);
        $paginaContentViewer = str_replace('<title/>', $titolo, $paginaContentViewer);
        $paginaContentViewer = str_replace('img/', "Articoli/".$articolo."/img\/", $paginaContentViewer);
    }else{
        $paginaContentViewer = file_get_contents('../404.html');
    }
    echo $paginaContentViewer;
?>