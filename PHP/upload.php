<?php
require_once "db.php";
use DB\DBAccess;
$target_dir = "Uploads/";
$target_file = $target_dir . basename($_FILES["zipfile"]["name"]);
$uploadOk = 1;
$zipFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    if(is_uploaded_file($_FILES['zipfile']['tmp_name'])){
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        
        // Check file size
        if ($_FILES["zipfile"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        
        // Allow certain file formats
        if($zipFileType != "zip" && $zipFileType != "rar" && $zipFileType != "7z") {
            echo "Sorry, only ZIP, RAR, 7Z files are allowed.";
            $uploadOk = 0;
        }
        
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            $path = $_FILES['zipfile']['tmp_name'];
            $destination= "../Uploads/".$_POST['tipo']."/";
            $tipo = $_POST['tipo'] == "Guide" ? 0 : 1;
            $filename = pathinfo($_FILES['zipfile']['name'])['filename'];
            $zip = new ZipArchive;
            if ($zip->open($path) === true) {
                $zip->extractTo($destination.$filename);
                $zip->close();
                $db = new DBAccess();
                $db->openDBConnection();
                $result = $db->addContent($_POST['tipo']."/".$filename, $tipo);
                if(isset($result) && $result){
                    //Tutto bene
                    header("Location: ../amministratore.html");
                }else if (isset($result)){
                    //Contenuto con lo stesso nome già presente nella stessa cartella
                }else{
                    //Errore nell'inserimento o nella verifica dell'unicità
                }
            }else{
                echo 'failed';
            }
        }
    }else{
        exit();
    }
}

?>