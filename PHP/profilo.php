<?php
    if (session_status() == PHP_SESSION_NONE) {session_start();}
    require_once "db.php";
    use DB\DBAccess;
    $paginaProfilo = file_get_contents('../profilo.html');
    if(isset($_SESSION['userid'])){
        //L'utente è loggato devo mostrare le statistiche
        $id = $_SESSION['userid'];
        $userForm = "<form id=\"profiloForm\" class=\"boxInside vflex\">
                        <div id=\"avatar\"></div>
                        <div id=\"campi\" class=\"vflex\">
                            <label for=\"email\">Email:</label>
                            <input type=\"text\" value=\" <email/> \" id=\"email\"></input>
                            <label for=\"password\" >Password:</label>
                            <input type=\"password\" value=\"password\" id=\"password\"></input>
                            <button id=\"azioneProfilo\">Modifica</button>
                            <input type=\"submit\" method=\"POST\" form =\"profiloForm\" formaction=\"logOut.php\" value = \"LogOut\" name=\"logout\" id=\"logout\">
                        </div>
                    </form>";
        $stats = "<div id=\"statistiche\" class=\"boxInside vflex\">
                        <h3>Statistiche</h3>
                        <ul id=\"infoProfilo\" class=\"boxInside highlight\">
                            <li id=\"karma\">Karma: <karma/></li>
                            <li id=\"eta\">Età virtuale: <br /> <eta/></li>
                            <li id=\"numeroPosts\">Numero posts: <npost/></li>
                        </ul>
                </div>";
        
        $db = new DBAccess();
        $db->openDBconnection();
        $userData = $db->getUserById($id);
        if(isset($userData)){
            $userForm = str_replace('<email/>', $userData['email'], $userForm);
            $karma = $db->getKarma($id);
            $stats = str_replace('<karma/>', isset($karma) ? $karma : '0', $stats);
            $now = time(); 
            $data_iscr = strtotime($userData['data_iscrizione']);
            $eta = $now - $data_iscr;
            $stats = str_replace('<eta/>', isset($eta) ? round(($eta / (60*60*24)))." giorni": '0 giorni', $stats);
            $npost = $db->getNumeroPost($id);
            $stats = str_replace('<npost/>', isset($npost) ? $npost : '0', $stats); 
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
            $latestPosts = "<div id=\"posts\" class=\"boxInside highlight hflex\"><h3>Ultimi post:</h3>".$postHtml."</div>";
            $paginaProfilo = str_replace('<latestPosts />', $latestPosts, $paginaProfilo);
            
        }else{
            $userForm = str_replace('<uname/>', 'Errore', $userForm);
        }
        $paginaProfilo = str_replace('<loginForm />', $userForm, $paginaProfilo);
        $paginaProfilo = str_replace('<stats />', $stats, $paginaProfilo);
        
    }else{
        //L'utente non è loggato devo mostrare il logins
        $loginForm = "<form id=\"loginForm\" class=\"boxInside vflex\" action=\"logIn.php?\" method=\"POST\" target=\"_self\">
                        <div id=\"campi\" class=\"vflex\">
                            <label for=\"email\"><b>Email:</b></label>
                            <input type=\"text\" placeholder=\"Enter Email\" name=\"email\" value=\"<email/>\" id=\"email\" oninput=\"return clearLoginErrorMessage()\" required>
                            <label for=\"psw\"><b>Password:</b></label>
                            <input type=\"password\" placeholder=\"Enter Password\" name=\"password\" id=\"password\" oninput=\"return clearLoginErrorMessage()\" required>
                            <div class=\"hflex\">
                                <label for=\"showPassword\" class='smalltext'><input type=\"checkbox\" name=\"showPassword\" id=\"showPassword\" onclick=\"return togglePassword()\" value=\"show\">Mostra password</label>
                            </div>
                            <div id=\"clogin\" class=\"errormsg\"><loginError/></div>
                            <div class=\"hflex\">
                                <button type=\"button\" class=\"cancelbtn\" onclick=\"return clearLoginFields()\">Cancella</button>
                                <button type=\"submit\">Login</button>
                            </div>
                            <p>Non hai un account? <a href = \"registrazione.php\" >Registrati</a></p>
                        </div>
                    </form>";
        if(isset($_SESSION['msg']['loginError']) && $_SESSION['msg']['loginError']){
            $loginForm = str_replace('<loginError/>', 'Nessun utente con questa email e password', $loginForm);
            $loginForm = str_replace('<email/>',$_SESSION['msg']['usedEmail'],$loginForm);
        }   
        else{
            $loginForm = str_replace('<loginError/>', '', $loginForm);
            $loginForm = str_replace('<email/>','',$loginForm);
        }
            
        $paginaProfilo = str_replace('<loginForm />', $loginForm, $paginaProfilo);
        $paginaProfilo = str_replace('<stats />', '', $paginaProfilo);
        $paginaProfilo = str_replace('<latestPosts />', '', $paginaProfilo);
    }
    session_unset();
    echo $paginaProfilo;

?>