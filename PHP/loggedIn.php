<?php
    session_start();
    require_once "db.php";
    use DB\DBAccess;
    $paginaProfilo = file_get_contents('../profilo.html');
    if(isset($_SESSION['userid']) && isset($_SESSION['privilegio'])){
        //L'utente è loggato devo mostrare le statistiche
        $id = $_SESSION['userid'];
        $db = new DBAccess();
        $db->openDBconnection();
        $userData = $db->getUserById($id);
        if(isset($userData)){
            $paginaProfilo = str_replace('<email/>', $userData['email'], $paginaProfilo);
            $karma = $db->getKarma($id);
            $paginaProfilo = str_replace('<karma/>', isset($karma) ? $karma : '0', $paginaProfilo);
            $now = time(); 
            $data_iscr = strtotime($userData['data_iscrizione']);
            $eta = $now - $data_iscr;
            $paginaProfilo = str_replace('<eta/>', isset($eta) ? round(($eta / (60*60*24)))." giorni": '0 giorni', $paginaProfilo);
            $npost = $db->getNumeroPost($id);
            $paginaProfilo = str_replace('<npost/>', isset($npost) ? $npost : '0', $paginaProfilo); 
            $posts = $db->getLatestPosts($id);
            $db->closeDBConnection();
            $postHtml = "Non hai ancora creato nessun post.";
            if(isset($posts)){
                if(count($posts)>0){
                    foreach($posts as $post){
                        $postHtml=$postHtml."<div class=\"boxOutside\"><p>".$post['testo']."</p></div>";
                    }
                }else{
                    $postHtml = "Non hai ancora creato nessun post.";
                }
            }

            $paginaProfilo = str_replace('<latestPosts/>', $postHtml, $paginaProfilo);
            
        }else{
            $paginaProfilo = str_replace('<uname/>', 'Errore caricamento', $userForm);
        }
        if($_SESSION['privilegio'] == "1"){
            $paginaProfilo = str_replace('<admin/>', '<li><a href="../amministratore.html">Admin</a></li>', $paginaProfilo);
        }else{
            $paginaProfilo = str_replace('<admin/>', '', $paginaProfilo);
        }
        echo $paginaProfilo;
    }
?>