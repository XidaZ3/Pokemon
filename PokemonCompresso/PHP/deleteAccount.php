<?php
    session_start();
    require_once "db.php";
    use DB\DBAccess;
    $db = new DBAccess();
    //Raccolgo le informazioni necessarie ad individuare l'utente e effettuare un controllo sulla password
    $id = isset($_POST['id']) && is_numeric($_POST['id']) ? $_POST['id'] : null;
    $psw = isset($_POST['password']) && is_string($_POST['password']) ? $_POST['password']: null;
    
    if(isset($id) && isset($psw)){
        $db->openDBConnection();
        //Prelevo le informazioni dell'utente
        $user = $db->getUserById($id);
        //Verifico la password 
        if(isset($user) && password_verify($psw,$user['password'])){
            //L'entry relativa all'utente non viene effettivamente eliminata, ma il suo stato passa da attivo a inattivo
            $db->disableUser($id);
            session_unset();
            session_destroy();
        }
        $db->closeDBConnection();
    }
    
?>