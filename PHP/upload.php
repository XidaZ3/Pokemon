<?php
session_start();
require_once "db.php";
use DB\DBAccess;
$tipo = isset($_POST['tipo']) && $_POST['tipo'] == "Guide" ? 0 : 1;
$target_dir = $tipo ? "Articoli/" : "Guide/";
$target_file = $target_dir . basename($_FILES["zipfile"]["name"]);
$uploadOk = 1;
$error = array();
$zipFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    if(is_uploaded_file($_FILES['zipfile']['tmp_name'])){
        if (file_exists($target_file)) {
            $uploadOk = 0;
            array_push($error,'Esiste già un file con questo nome.');
        }
        
        // Check file size
        if ($_FILES["zipfile"]["size"] > 1000000) {
            $uploadOk = 0;
            array_push($error,"Il file supera la dimensione massima. (1MB)");
        }
        
        // Allow certain file formats
        if($zipFileType != "zip" && $zipFileType != "rar" && $zipFileType != "7z") {
            $uploadOk = 0;
            array_push($error,"L'estensioni supportate sono .zip, .rar e .7z");
        }
        
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
        // if everything is ok, try to upload file
        } else {
            $path = $_FILES['zipfile']['tmp_name'];
            $destination= "../".$_POST['tipo']."/";
            $title = $_POST['titolo'];
            $filename = pathinfo($_FILES['zipfile']['tmp_name'])['filename'];
            $zip = new ZipArchive;
            if ($zip->open($path) === true) {
                $upload = $zip->extractTo($destination.$filename);
                $zip->close();
                if(is_bool($upload) && $upload){
                    array_push($error,"Il file è stato aggiunto correttamente nella directory del server.");
                    $db = new DBAccess();
                    $db->openDBConnection();
                    $result = $db->addContent($filename,$tipo,$title);
                    if(isset($result) && $result){
                        if($tipo == 0)
                            $link = "<a href=\"../contentViewer.php?guida={$filename}&titolo={$title}\">{$title}</a>";
                        else if($tipo ==1)
                            $link = "<a href=\"../contentViewer.php?articolo={$filename}&titolo={$title}\">{$title}</a>";
                        array_push($error,$link);
                        $_SESSION['uploadError']=$error;
                        header("Location: amministratore.php");
                    }else if (isset($result)){
                        array_push($error,"Non è stato possibile aggiornare il database.");
                    }else{
                        array_push($error,"Errore nel tentativo di aggiornare il database");
                    }
                }
                else
                    array_push($error,"Non è stato possibile estrarre i file sulla directory del server.");
                
            }else{
                array_push($error,"Non è stato possibile aprire il file per l'estrazione.");
            }
        }
        $_SESSION['uploadError']=$error;
        header("Location: amministratore.php");
    }else{
        exit();
    }
}

?>