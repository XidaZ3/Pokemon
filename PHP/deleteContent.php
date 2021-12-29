<?php 
    session_start();
    require_once "db.php";
    use DB\DBAccess;
    $contentSelected = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : -1;
    $privilegio = isset($_SESSION['privilegio']) && is_numeric($_SESSION['privilegio']) ? $_SESSION['privilegio'] : 0;
    $tipo = isset($_GET['tipo']) && is_numeric($_GET['tipo']) && !$_GET['tipo'] ? "Guide" : "Articoli";
    $path = isset($_GET['path']) && is_string($_GET['path']) ? $_GET['path'] : null;
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 0;
    if($privilegio == 1 && $contentSelected != -1 && isset($path) && is_string($tipo)){
        $db = new DBAccess();
        $db->openDBConnection();
        $result = $db->deleteContent($contentSelected);
        if(isset($result) && $result){
            
            $dir = '..' . DIRECTORY_SEPARATOR . $tipo. DIRECTORY_SEPARATOR . $path ;
            $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
            $files = new RecursiveIteratorIterator($it,
                        RecursiveIteratorIterator::CHILD_FIRST);
            foreach($files as $file) {
                if ($file->isDir()){
                    rmdir($file->getRealPath());
                } else {
                    unlink($file->getRealPath());
                }
            }
            $result = rmdir($dir);
            if($result){
                header("Location: contenuti.php?page={$page}&tipo={$tipo}");
            }
        }
    }
    
?>