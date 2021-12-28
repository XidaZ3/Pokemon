<?php
    namespace DB;
    class DBAccess{
        private const HOST_DB = "127.0.0.1";
        private const DB_NAME = "pokefriends"; #pmarcatt
        private const USERNAME = "root"; #pmarcatt
        private const PASSWORD = ""; #koShaituayeo7fae

        private $connection;

        public function openDBConnection(){
            $this->connection = mysqli_connect(DBAccess::HOST_DB,DBAccess::USERNAME,DBAccess::PASSWORD,DBAccess::DB_NAME);
            return mysqli_errno($this->connection);
        }

        public function closeDBConnection(){
            mysqli_close($this->connection);
        }

        private function pulisciInput($valore, $filters){
            return filter_input(INPUT_POST, $valore, $filters);
        }

        public function getUser($email, $psw){
            //$email = $this->pulisciInput($email, FILTER_DEFAULT,[/*FILTER_SANITIZE_EMAIL, FILTER_SANITIZE_MAGIC_QUOTES, FILTER_SANITIZE_STRING*/]); //Filtraggio dell'input, vuoto perchè la prof deve poter inserire le stesse credenziali in automatico
            //$psw = $this->pulisciInput($psw, FILTER_DEFAULT, [FILTER_SANITIZE_MAGIC_QUOTES, FILTER_SANITIZE_STRING]); //Filtraggio della password
            $query = "SELECT * FROM utenti WHERE email = '$email' AND attivo=1";
            $queryResult = mysqli_query($this->connection, $query) or die("Errore in getUser: ".mysqli_error($this->connection));
            if(mysqli_num_rows($queryResult) >0){
                //Mail trovata nel database, viene fetchato "l'array" (1 solo elemento)
                $result = array();
                while($row = mysqli_fetch_assoc($queryResult)){
                    array_push($result, $row);
                }
                $queryResult->free();
                //Verifica della password con quella inserita 
                if(password_verify($psw, $result[0]['password'])){
                    return $result[0]; //La password è corretta
                }else{
                    return null;
                }
            }else{
                return null;
            }
            
        }

        public function deleteUser($id){
            $query = "UPDATE utenti SET attivo = 0 WHERE id=$id";
            $queryResult = mysqli_query($this->connection, $query) or die("Errore in getUser: ".mysqli_error($this->connection));
            return $queryResult;
        }

        public function getUserById($id){
            $query = "SELECT * FROM utenti WHERE id=$id AND attivo=1";
            $queryResult = mysqli_query($this->connection, $query) or die("Errore in getUserById: ".mysqli_error($this->connection));
            if(mysqli_num_rows($queryResult) >0){
                //Mail trovata nel database, viene fetchato "l'array" (1 solo elemento)
                $result = array();
                while($row = mysqli_fetch_assoc($queryResult)){
                    array_push($result, $row);
                }
                $queryResult->free();
                return $result[0];
            }else{
                return null;
            }
        }

        public function getUserByUsername($username){
            $query = "SELECT * FROM utenti WHERE username='$username' AND attivo=1";
            $queryResult = mysqli_query($this->connection, $query) or null;
            if(mysqli_num_rows($queryResult) >0){
                //Username trovato nel database, viene fetchato "l'array" (1 solo elemento)
                $result = array();
                while($row = mysqli_fetch_assoc($queryResult)){
                    array_push($result, $row);
                }
                $queryResult->free();
                return $result[0];
            }else{
                return null;
            }
        }

        public function getUserByEmail($email){
            $query = "SELECT * FROM utenti WHERE email='$email' AND attivo=1";
            $queryResult = mysqli_query($this->connection, $query) or null;
            if(mysqli_num_rows($queryResult) >0){
                //Mail trovata nel database, viene fetchato "l'array" (1 solo elemento)
                $result = array();
                while($row = mysqli_fetch_assoc($queryResult)){
                    array_push($result, $row);
                }
                $queryResult->free();
                return $result[0];
            }else{
                return null;
            }
        }

        public function isEmailUsed($email){
            $email = $this->pulisciInput($email, FILTER_DEFAULT,[/*FILTER_SANITIZE_EMAIL, FILTER_SANITIZE_MAGIC_QUOTES, FILTER_SANITIZE_STRING*/]); 
            //Filtraggio dell'input, vuoto perchè la prof deve poter inserire le stesse credenziali in automatico
            $query = "SELECT id FROM utenti WHERE email = '$email'";
            $queryResult = mysqli_query($this->connection, $query) or die("Errore in isEmailUsed: ".mysqli_error($this->connection));
            if(mysqli_num_rows($queryResult) >1){
                return true;
            }else{
                return false;
            }
        }

        public function addUser($email, $psw, $uname) {
            //$email = $this->pulisciInput($email, FILTER_DEFAULT,[/*FILTER_SANITIZE_EMAIL, FILTER_SANITIZE_MAGIC_QUOTES, FILTER_SANITIZE_STRING*/]); //Filtraggio dell'input, vuoto perchè la prof deve poter inserire le stesse credenziali in automatico
            //$psw = $this->pulisciInput($psw, FILTER_DEFAULT, [FILTER_SANITIZE_MAGIC_QUOTES, FILTER_SANITIZE_STRING]); //Filtraggio della password
            $emailUsed = $this->isEmailUsed($email); // Verifico che l'email non sia già stata utilizzata, se questa variabile è vuota proseguo
            if(!$emailUsed){
                $psw = password_hash($psw,PASSWORD_BCRYPT);//Hash della password che unisce anche il salt per la verifica in un unica stringa di 60 caratteri
                $query = "INSERT INTO utenti (email,password,username,privilegio) VALUES ('$email', '$psw', '$uname',0)";
                    $queryResult = mysqli_query($this->connection, $query) or null;
                    return $queryResult; //Ritorna true se l'inserimento è avvenuto con successo, false altrimenti
            }
            
        }

        public function getKarma($id) {
            if(isset($id)){
                $query = "SELECT COUNT(valore), SUM(valore) as karma from karma_commenti k, commenti c WHERE k.commento = c.id AND c.utente = $id GROUP BY k.id";
                $queryResult = mysqli_query($this->connection, $query) or die("Errore in getKarma: ".mysqli_error($this->connection));
                if(mysqli_num_rows($queryResult)>0){
                    $result = array();
                    while($row = mysqli_fetch_assoc($queryResult)){
                        array_push($result, $row);
                    }
                    $queryResult->free();
                    return $result[0]['karma'];
                }else{
                    return null;
                }
            }
        }

        public function getEta($id) {
            if(isset($id)){
                $query = "SELECT data_iscrizione as dataI from utenti WHERE utenti.id = $id";
                $queryResult = mysqli_query($this->connection, $query) or die("Errore in getEta: ".mysqli_error($this->connection));
                if(mysqli_num_rows($queryResult)>0){
                    $result = array();
                    while($row = mysqli_fetch_assoc($queryResult)){
                        array_push($result, $row);
                    }
                    $queryResult->free();
                    return $result[0]['dataI'];
                }else{
                    return null;
                }
            }
        }

        public function getNumeroPost($id) {
            if(isset($id)){
                $query = "SELECT COUNT(commenti.utente) AS npost FROM commenti WHERE commenti.utente = $id GROUP BY commenti.utente";
                $queryResult = mysqli_query($this->connection, $query) or die("Errore in getNumeroPost: ".mysqli_error($this->connection));
                if(mysqli_num_rows($queryResult)>0){
                    $result = array();
                    while($row = mysqli_fetch_assoc($queryResult)){
                        array_push($result, $row);
                    }
                    $queryResult->free();
                    return $result[0]['npost'];
                }else{
                    return null;
                }
            }
        }

        public function getLatestPosts($id) {
            if(isset($id)){
                $query = "SELECT commenti.* FROM commenti WHERE commenti.utente = $id ORDER BY commenti.timestamp DESC LIMIT 3";
                $queryResult = mysqli_query($this->connection, $query) or die("Errore in getLatestPost: ".mysqli_error($this->connection));
                if(mysqli_num_rows($queryResult)>0){
                    $result = array();
                    while($row = mysqli_fetch_assoc($queryResult)){
                        array_push($result, $row);
                    }
                    $queryResult->free();
                    return $result;
                }else{
                    return null;
                }
            }
        }

        public function addContent($path,$tipo,$titolo) {
            $pathUsed = $this->isPathUsed($path); // Verifico che l'email non sia già stata utilizzata, se questa variabile è vuota proseguo
            if(is_null($pathUsed)){
                $query = "INSERT INTO contenuti (path,tipo, titolo) VALUES ('$path', $tipo,'$titolo')";
                    $queryResult = mysqli_query($this->connection, $query) or null;
                    return $queryResult; //Ritorna true se l'inserimento è avvenuto con successo, false altrimenti
            }else{
                return null;
            }
        }

        private function isPathUsed($path) {
            $query = "SELECT id FROM contenuti WHERE path = '$path'";
            $queryResult = mysqli_query($this->connection, $query) or die("Errore in isPathUsed: ".mysqli_error($this->connection));
            if(mysqli_num_rows($queryResult)>0){
                $result = array();
                while($row = mysqli_fetch_assoc($queryResult)){
                    array_push($result, $row);
                }
                $queryResult->free();
                return $result;
            }else{
                return null;
            }
        
        }

        public function getGuideContentsMostRecent($page) {
            $offset = $page * 10;
            $query = "SELECT c.path, c.tipo, c.titolo,c.id, c.data_creazione,u.username, IFNULL(SUM(NULL), 0) as karma, COUNT(co.contenuto) as ncom   
            FROM contenuti c LEFT JOIN karma_contenuti k ON c.id = k.contenuto LEFT JOIN commenti co ON c.id = co.contenuto JOIN utenti u ON c.editore=u.id
            WHERE tipo = 0
            GROUP BY c.path,c.tipo,c.titolo,c.data_creazione,c.id,u.username ORDER BY c.data_creazione DESC LIMIT $offset, 10 ";
            $queryResult = mysqli_query($this->connection, $query) or die("Errore in getGuideContents: ".mysqli_error($this->connection));
            if(mysqli_num_rows($queryResult)>0){
                $result = array();
                while($row = mysqli_fetch_assoc($queryResult)){
                    array_push($result, $row);
                }
                $queryResult->free();
                return $result;
            }else{
                return null;
            }
        }

        public function getGuideContentsLeastRecent($page) {
            $offset = $page * 10;
            $query = "SELECT c.path, c.tipo, c.titolo,c.id, c.data_creazione,u.username, IFNULL(SUM(NULL), 0) as karma, COUNT(co.contenuto) as ncom   
            FROM contenuti c LEFT JOIN karma_contenuti k ON c.id = k.contenuto LEFT JOIN commenti co ON c.id = co.contenuto JOIN utenti u ON c.editore=u.id
            WHERE tipo = 0
            GROUP BY c.path,c.tipo,c.titolo,c.data_creazione,c.id,u.username ORDER BY c.data_creazione ASC LIMIT $offset, 10 ";
            $queryResult = mysqli_query($this->connection, $query) or die("Errore in getGuideContents: ".mysqli_error($this->connection));
            if(mysqli_num_rows($queryResult)>0){
                $result = array();
                while($row = mysqli_fetch_assoc($queryResult)){
                    array_push($result, $row);
                }
                $queryResult->free();
                return $result;
            }else{
                return null;
            }
        }

        public function getGuideContentsMostKarma($page) {
            $offset = $page * 10;
            $query = "SELECT c.path, c.tipo, c.titolo,c.id, c.data_creazione,u.username, IFNULL(SUM(NULL), 0) as karma, COUNT(co.contenuto) as ncom   
            FROM contenuti c LEFT JOIN karma_contenuti k ON c.id = k.contenuto LEFT JOIN commenti co ON c.id = co.contenuto JOIN utenti u ON c.editore=u.id
            WHERE tipo = 0
            GROUP BY c.path,c.tipo,c.titolo,c.data_creazione,c.id,u.username ORDER BY karma DESC LIMIT $offset, 10 ";
            $queryResult = mysqli_query($this->connection, $query) or die("Errore in getGuideContents: ".mysqli_error($this->connection));
            if(mysqli_num_rows($queryResult)>0){
                $result = array();
                while($row = mysqli_fetch_assoc($queryResult)){
                    array_push($result, $row);
                }
                $queryResult->free();
                return $result;
            }else{
                return null;
            }
        }

        public function getGuideContentsMostComments($page) {
            $offset = $page * 10;
            $query = "SELECT c.path, c.tipo, c.titolo,c.id, c.data_creazione,u.username, IFNULL(SUM(NULL), 0) as karma, COUNT(co.contenuto) as ncom   
            FROM contenuti c LEFT JOIN karma_contenuti k ON c.id = k.contenuto LEFT JOIN commenti co ON c.id = co.contenuto JOIN utenti u ON c.editore=u.id
            WHERE tipo = 0
            GROUP BY c.path,c.tipo,c.titolo,c.data_creazione,c.id,u.username ORDER BY ncom DESC LIMIT $offset, 10 ";
            $queryResult = mysqli_query($this->connection, $query) or die("Errore in getGuideContents: ".mysqli_error($this->connection));
            if(mysqli_num_rows($queryResult)>0){
                $result = array();
                while($row = mysqli_fetch_assoc($queryResult)){
                    array_push($result, $row);
                }
                $queryResult->free();
                return $result;
            }else{
                return null;
            }
        }

        public function getArticleContentsMostRecent($page) {
            $offset = $page * 10;
            if(isset($page)){
                $query = "SELECT c.path, c.tipo, c.titolo,c.id, c.data_creazione,u.username, IFNULL(SUM(NULL), 0) as karma, COUNT(co.contenuto) as ncom   
                FROM contenuti c LEFT JOIN karma_contenuti k ON c.id = k.contenuto LEFT JOIN commenti co ON c.id = co.contenuto JOIN utenti u ON c.editore=u.id
                WHERE tipo = 1
                GROUP BY c.path,c.tipo,c.titolo,c.data_creazione,c.id,u.username ORDER BY c.data_creazione DESC LIMIT $offset, 10";
                $queryResult = mysqli_query($this->connection, $query) or die("Errore in getArticleContents: ".mysqli_error($this->connection));
                if(mysqli_num_rows($queryResult)>0){
                    $result = array();
                    while($row = mysqli_fetch_assoc($queryResult)){
                        array_push($result, $row);
                    }
                    $queryResult->free();
                    return $result;
                }else{
                    return null;
                }
            }
        }

        public function getArticleContentsLeastRecent($page) {
            $offset = $page * 10;
            if(isset($page)){
                $query = "SELECT c.path, c.tipo, c.titolo,c.id, c.data_creazione,u.username, IFNULL(SUM(NULL), 0) as karma, COUNT(co.contenuto) as ncom   
                FROM contenuti c LEFT JOIN karma_contenuti k ON c.id = k.contenuto LEFT JOIN commenti co ON c.id = co.contenuto JOIN utenti u ON c.editore=u.id
                WHERE tipo = 1
                GROUP BY c.path,c.tipo,c.titolo,c.data_creazione,c.id,u.username ORDER BY c.data_creazione ASC LIMIT $offset, 10";
                $queryResult = mysqli_query($this->connection, $query) or die("Errore in getArticleContents: ".mysqli_error($this->connection));
                if(mysqli_num_rows($queryResult)>0){
                    $result = array();
                    while($row = mysqli_fetch_assoc($queryResult)){
                        array_push($result, $row);
                    }
                    $queryResult->free();
                    return $result;
                }else{
                    return null;
                }
            }
        }

        public function getArticleContentsMostKarma($page) {
            $offset = $page * 10;
            if(isset($page)){
                $query = "SELECT c.path, c.tipo, c.titolo,c.id, c.data_creazione,u.username, IFNULL(SUM(NULL), 0) as karma, COUNT(co.contenuto) as ncom   
                FROM contenuti c LEFT JOIN karma_contenuti k ON c.id = k.contenuto LEFT JOIN commenti co ON c.id = co.contenuto JOIN utenti u ON c.editore=u.id
                WHERE tipo = 1
                GROUP BY c.path,c.tipo,c.titolo,c.data_creazione,c.id,u.username ORDER BY karma DESC LIMIT $offset, 10";
                $queryResult = mysqli_query($this->connection, $query) or die("Errore in getArticleContents: ".mysqli_error($this->connection));
                if(mysqli_num_rows($queryResult)>0){
                    $result = array();
                    while($row = mysqli_fetch_assoc($queryResult)){
                        array_push($result, $row);
                    }
                    $queryResult->free();
                    return $result;
                }else{
                    return null;
                }
            }
        }

        public function getArticleContentsMostComments($page) {
            $offset = $page * 10;
            if(isset($page)){
                $query = "SELECT c.path, c.tipo, c.titolo,c.id, c.data_creazione,u.username, IFNULL(SUM(NULL), 0) as karma, COUNT(co.contenuto) as ncom   
                FROM contenuti c LEFT JOIN karma_contenuti k ON c.id = k.contenuto LEFT JOIN commenti co ON c.id = co.contenuto JOIN utenti u ON c.editore=u.id
                WHERE tipo = 1
                GROUP BY c.path,c.tipo,c.titolo,c.data_creazione,c.id,u.username ORDER BY ncom DESC LIMIT $offset, 10";
                $queryResult = mysqli_query($this->connection, $query) or die("Errore in getArticleContents: ".mysqli_error($this->connection));
                if(mysqli_num_rows($queryResult)>0){
                    $result = array();
                    while($row = mysqli_fetch_assoc($queryResult)){
                        array_push($result, $row);
                    }
                    $queryResult->free();
                    return $result;
                }else{
                    return null;
                }
            }
        }

        public function getContentComments($id,$userid) {
            $query = "SELECT co.id as commentoid, co.testo, co.timestamp, u.username,u.id as userid, k.valore FROM commenti co JOIN utenti u ON co.utente = u.id LEFT JOIN karma_commenti k ON k.commento = co.id AND k.utente = $userid WHERE co.contenuto = $id ORDER BY commentoid DESC";
            $queryResult = mysqli_query($this->connection, $query) or die("Errore in getArticleContents: ".mysqli_error($this->connection));
            if(mysqli_num_rows($queryResult)>0){
                $result = array();
                while($row = mysqli_fetch_assoc($queryResult)){
                    array_push($result, $row);
                }
                $queryResult->free();
                return $result;
            }else{
                return null;
            }
        }

        public function getContentsMostRecent() {
            $query = "SELECT c.path, c.tipo, c.titolo,c.id, c.data_creazione,u.username, IFNULL(SUM(NULL), 0) as karma, COUNT(co.contenuto) as ncom   
            FROM contenuti c LEFT JOIN karma_contenuti k ON c.id = k.contenuto LEFT JOIN commenti co ON c.id = co.contenuto JOIN utenti u ON c.editore=u.id
            GROUP BY c.path,c.tipo,c.titolo,c.data_creazione,c.id,u.username ORDER BY c.data_creazione DESC LIMIT 5";
            $queryResult = mysqli_query($this->connection, $query) or die("Errore in getContentsMostRecent: ".mysqli_error($this->connection));
            if(mysqli_num_rows($queryResult)>0){
                $result = array();
                while($row = mysqli_fetch_assoc($queryResult)){
                    array_push($result, $row);
                }
                $queryResult->free();
                return $result;
            }else{
                return null;
            }
            
        }

        public function getContentsMostKarma() {
            $query = "SELECT c.path, c.tipo, c.titolo,c.id, c.data_creazione,u.username, IFNULL(SUM(NULL), 0) as karma, COUNT(co.contenuto) as ncom   
            FROM contenuti c LEFT JOIN karma_contenuti k ON c.id = k.contenuto LEFT JOIN commenti co ON c.id = co.contenuto JOIN utenti u ON c.editore=u.id
            GROUP BY c.path,c.tipo,c.titolo,c.data_creazione,c.id,u.username ORDER BY karma DESC LIMIT 5";
            $queryResult = mysqli_query($this->connection, $query) or die("Errore in getContentsMostKarma: ".mysqli_error($this->connection));
            if(mysqli_num_rows($queryResult)>0){
                $result = array();
                while($row = mysqli_fetch_assoc($queryResult)){
                    array_push($result, $row);
                }
                $queryResult->free();
                return $result;
            }else{
                return null;
            }
            
        }

        public function addComment($user,$comment,$contenuto)
        {
            //need to sanitize comment
            $query = "INSERT INTO commenti(utente,testo,contenuto) VALUES ('$user', '$comment', '$contenuto')";
            $queryResult = mysqli_query($this->connection, $query) or null;
            return $queryResult; //Ritorna true se l'inserimento è avvenuto con successo, false altrimenti
        }

        // public function addContentOpinion($content,$opinion)
        // {
        //     //need to sanitize comment
        //     $query = "INSERT INTO commenti(utente,testo,contenuto) VALUES ('$user', '$comment', '$contenuto')";
        //     $queryResult = mysqli_query($this->connection, $query) or null;
        //     return $queryResult; //Ritorna true se l'inserimento è avvenuto con successo, false altrimenti
        // }

        public function addCommentOpinion($comment,$user, $opinion)
        {
            $comment=substr($comment,2);
            $query = "SELECT commento FROM karma_commenti WHERE $comment = commento";
            $queryResult = mysqli_query($this->connection, $query) or null;

            if($queryResult)
            {
                if(mysqli_num_rows($queryResult)==0)
                    $query = "INSERT INTO karma_commenti(commento,utente,valore) VALUES ('$comment', '$user', '$opinion')";
                else{
                    if($opinion != 0)
                        $query = "UPDATE karma_commenti SET valore=$opinion WHERE commento=$comment AND utente=$user";
                    else
                        $query = "DELETE FROM karma_commenti WHERE commento=$comment AND utente=$user";
                }

                $queryResult = mysqli_query($this->connection, $query) or null;
            }
            return $queryResult;
        }
    };
?>