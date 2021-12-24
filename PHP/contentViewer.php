<?php
    session_start();
    require_once "db.php";
    use DB\DBAccess;
    $db = new DBAccess();
    $paginaContentViewer = file_get_contents('../visualizzazione_contenuti.html');
    $guida = isset($_GET['guida']) ? $_GET['guida'] : null;
    $articolo = isset($_GET['articolo']) ? $_GET['articolo'] : null;
    $titolo = isset($_GET['titolo']) ? $_GET['titolo']: null;
    $db->openDBConnection();
    if(isset($guida) && isset($titolo)){
        $content = file_get_contents('../Uploads/Guide/'.$guida.'/index.html');
        $paginaContentViewer = str_replace('<content/>', $content, $paginaContentViewer);
        $paginaContentViewer = str_replace('<title/>', $titolo, $paginaContentViewer);
    }else if(isset($articolo) && isset($titolo)){
        $content = file_get_contents('../Uploads/Articoli/'.$articolo.'/index.html');
        $paginaContentViewer = str_replace('<content/>', $content, $paginaContentViewer);
        $paginaContentViewer = str_replace('<title/>', $titolo, $paginaContentViewer);
    }else{
        $paginaContentViewer = file_get_contents('../404.html');
    }
    echo $paginaContentViewer;
?>