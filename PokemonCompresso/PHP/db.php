<?php
    namespace DB;
    class DBAccess{
        private const HOST_DB = "127.0.0.1";
        private const DB_NAME = "pokefriends"; #pmarcatt
        private const USERNAME = "root"; #pmarcatt
        private const PASSWORD = ""; #koShaituayeo7fae
        private $contenutiPerPagina = 5;

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

        public function getUser($username, $psw){
            $query = "SELECT * FROM utenti WHERE username = '$username' AND attivo=1";
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

        public function disableUser($id){
            $query = "UPDATE utenti SET attivo = 0 WHERE id=$id";
            $queryResult = mysqli_query($this->connection, $query) or die("Errore in disableUser: ".mysqli_error($this->connection));
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
            $query = "SELECT id FROM utenti WHERE email = '$email'";
            $queryResult = mysqli_query($this->connection, $query) or die("Errore in isEmailUsed: ".mysqli_error($this->connection));
            if(mysqli_num_rows($queryResult) >1){
                return true;
            }else{
                return false;
            }
        }

        public function addUser($email, $psw, $uname) {
            $avatar = rand(1,386);
            $emailUsed = $this->isEmailUsed($email); // Verifico che l'email non sia già stata utilizzata, se questa variabile è vuota proseguo
            if(!$emailUsed){
                $psw = password_hash($psw,PASSWORD_BCRYPT);//Hash della password che unisce anche il salt per la verifica in un unica stringa di 60 caratteri
                $query = "INSERT INTO utenti (email,password,username,privilegio,avatar) VALUES ('$email', '$psw', '$uname',0,$avatar)";
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

        public function getContentByPath($path) {
            if(isset($path)){
                $query = "SELECT contenuti.* FROM contenuti WHERE path = '$path'";
                $queryResult = mysqli_query($this->connection, $query) or die("Errore in getContentByPath: ".mysqli_error($this->connection));
                if(mysqli_num_rows($queryResult)>0){
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

        public function addContent($path,$tipo,$titolo,$editore) {
            $pathUsed = $this->isPathUsed($path); // Verifico che l'email non sia già stata utilizzata, se questa variabile è vuota proseguo
            if(is_null($pathUsed)){
                $query = "INSERT INTO contenuti (path,tipo, titolo, editore) VALUES ('$path', $tipo,'$titolo', $editore)";
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

        public function getContentNumberByType($tipo){
            $query= "SELECT COUNT(c.id) as ncontenuti FROM contenuti c WHERE c.tipo = $tipo";
            $queryResult = mysqli_query($this->connection, $query) or die("Errore in getContentNumberByType: ".mysqli_error($this->connection));
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
            $offset = $page * $this->contenutiPerPagina;
            $query = "SELECT c.path, c.tipo, c.titolo,c.id, c.data_creazione,u.username editore, u.avatar avatar,
            IFNULL((SELECT SUM(valore) from karma_contenuti k WHERE k.contenuto = c.id),0) karma, COUNT(co.contenuto) as ncom 
            FROM contenuti c LEFT JOIN karma_contenuti k ON c.id = k.contenuto LEFT JOIN commenti co ON c.id = co.contenuto JOIN utenti u ON c.editore=u.id 
            WHERE tipo = 0 GROUP BY c.id 
            ORDER BY c.data_creazione DESC LIMIT $offset, 5";
            $queryResult = mysqli_query($this->connection, $query) or die("Errore in getGuideContentsMostRecent: ".mysqli_error($this->connection));
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
            $offset = $page * $this->contenutiPerPagina;
            $query = "SELECT c.path, c.tipo, c.titolo,c.id, c.data_creazione,u.username editore, u.avatar avatar,
            IFNULL((SELECT SUM(valore) from karma_contenuti k WHERE k.contenuto = c.id),0) karma, COUNT(co.contenuto) as ncom 
            FROM contenuti c LEFT JOIN karma_contenuti k ON c.id = k.contenuto LEFT JOIN commenti co ON c.id = co.contenuto JOIN utenti u ON c.editore=u.id 
            WHERE tipo = 0 GROUP BY c.id 
            ORDER BY c.data_creazione ASC LIMIT $offset, 5";
            $queryResult = mysqli_query($this->connection, $query) or die("Errore in getGuideContentsLeastRecent: ".mysqli_error($this->connection));
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
            $offset = $page * $this->contenutiPerPagina;
            $query = "SELECT c.path, c.tipo, c.titolo,c.id, c.data_creazione,u.username editore, u.avatar avatar,
            IFNULL((SELECT SUM(valore) from karma_contenuti k WHERE k.contenuto = c.id),0) karma, COUNT(co.contenuto) as ncom 
            FROM contenuti c LEFT JOIN karma_contenuti k ON c.id = k.contenuto LEFT JOIN commenti co ON c.id = co.contenuto JOIN utenti u ON c.editore=u.id 
            WHERE tipo = 0 GROUP BY c.id 
            ORDER BY karma DESC LIMIT $offset, 5";
            $queryResult = mysqli_query($this->connection, $query) or die("Errore in getGuideContentsMostKarma: ".mysqli_error($this->connection));
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
            $offset = $page * $this->contenutiPerPagina;
            $query = "SELECT c.path, c.tipo, c.titolo,c.id, c.data_creazione,u.username editore, u.avatar avatar,
            IFNULL((SELECT SUM(valore) from karma_contenuti k WHERE k.contenuto = c.id),0) karma, COUNT(co.contenuto) as ncom 
            FROM contenuti c LEFT JOIN karma_contenuti k ON c.id = k.contenuto LEFT JOIN commenti co ON c.id = co.contenuto JOIN utenti u ON c.editore=u.id 
            WHERE tipo = 0 GROUP BY c.id 
            ORDER BY ncom DESC LIMIT $offset, 5";
            $queryResult = mysqli_query($this->connection, $query) or die("Errore in getGuideContentsMostComments: ".mysqli_error($this->connection));
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
            $offset = $page * $this->contenutiPerPagina;
            if(isset($page)){
                $query = "SELECT c.path, c.tipo, c.titolo,c.id, c.data_creazione,u.username editore, u.avatar avatar,
                IFNULL((SELECT SUM(valore) from karma_contenuti k WHERE k.contenuto = c.id),0) karma, COUNT(co.contenuto) as ncom 
                FROM contenuti c LEFT JOIN karma_contenuti k ON c.id = k.contenuto LEFT JOIN commenti co ON c.id = co.contenuto JOIN utenti u ON c.editore=u.id 
                WHERE tipo = 1 GROUP BY c.id 
                ORDER BY c.data_creazione DESC LIMIT $offset, 5";
                $queryResult = mysqli_query($this->connection, $query) or die("Errore in getArticleContentsMostRecent: ".mysqli_error($this->connection));
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
            $offset = $page * $this->contenutiPerPagina;
            if(isset($page)){
                $query = "SELECT c.path, c.tipo, c.titolo,c.id, c.data_creazione,u.username editore, u.avatar avatar,
                IFNULL((SELECT SUM(valore) from karma_contenuti k WHERE k.contenuto = c.id),0) karma, COUNT(co.contenuto) as ncom 
                FROM contenuti c LEFT JOIN karma_contenuti k ON c.id = k.contenuto LEFT JOIN commenti co ON c.id = co.contenuto JOIN utenti u ON c.editore=u.id 
                WHERE tipo = 1 GROUP BY c.id 
                ORDER BY c.data_creazione Asc LIMIT $offset, 5";
                $queryResult = mysqli_query($this->connection, $query) or die("Errore in getArticleContentsLeastRecent: ".mysqli_error($this->connection));
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
            $offset = $page * $this->contenutiPerPagina;
            if(isset($page)){
                $query = "SELECT c.path, c.tipo, c.titolo,c.id, c.data_creazione,u.username editore, u.avatar avatar,
                IFNULL((SELECT SUM(valore) from karma_contenuti k WHERE k.contenuto = c.id),0) karma, COUNT(co.contenuto) as ncom 
                FROM contenuti c LEFT JOIN karma_contenuti k ON c.id = k.contenuto LEFT JOIN commenti co ON c.id = co.contenuto JOIN utenti u ON c.editore=u.id 
                WHERE tipo = 1 GROUP BY c.id 
                ORDER BY karma DESC LIMIT $offset, 5";
                $queryResult = mysqli_query($this->connection, $query) or die("Errore in getArticleContentsMostKarma: ".mysqli_error($this->connection));
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
            $offset = $page * $this->contenutiPerPagina;
            if(isset($page)){
                $query = "SELECT c.path, c.tipo, c.titolo,c.id, c.data_creazione,u.username editore, u.avatar avatar,
                IFNULL((SELECT SUM(valore) from karma_contenuti k WHERE k.contenuto = c.id),0) karma, COUNT(co.contenuto) as ncom 
                FROM contenuti c LEFT JOIN karma_contenuti k ON c.id = k.contenuto LEFT JOIN commenti co ON c.id = co.contenuto JOIN utenti u ON c.editore=u.id 
                WHERE tipo = 1 GROUP BY c.id 
                ORDER BY ncom DESC LIMIT $offset, 5";
                $queryResult = mysqli_query($this->connection, $query) or die("Errore in getArticleContentsMostComments: ".mysqli_error($this->connection));
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
            $query = "SELECT co.id as commentoid, co.contenuto, co.testo, co.timestamp, u.username,u.id as userid, u.avatar as avatar, k.valore, IFNULL(SUM(k.valore),0) as karma
             FROM commenti co JOIN utenti u ON co.utente = u.id LEFT JOIN karma_commenti k ON k.commento = co.id AND k.utente = $userid
             WHERE co.contenuto = $id GROUP BY commentoid 
             ORDER BY co.timestamp DESC, commentoid DESC";
            $queryResult = mysqli_query($this->connection, $query) or die("Errore in getContentComments: ".mysqli_error($this->connection));
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
            $query = "SELECT c.path, c.tipo, c.titolo,c.id, c.data_creazione,u.username editore, u.avatar avatar,
            IFNULL((SELECT SUM(valore) from karma_contenuti k WHERE k.contenuto = c.id),0) karma, COUNT(co.contenuto) as ncom 
            FROM contenuti c LEFT JOIN karma_contenuti k ON c.id = k.contenuto LEFT JOIN commenti co ON c.id = co.contenuto JOIN utenti u ON c.editore=u.id 
            GROUP BY c.id 
            ORDER BY c.data_creazione DESC LIMIT 3";
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
            $query = "SELECT c.path, c.tipo, c.titolo,c.id, c.data_creazione,u.username editore, u.avatar avatar,
            IFNULL((SELECT SUM(valore) from karma_contenuti k WHERE k.contenuto = c.id),0) karma, COUNT(co.contenuto) as ncom 
            FROM contenuti c LEFT JOIN karma_contenuti k ON c.id = k.contenuto LEFT JOIN commenti co ON c.id = co.contenuto JOIN utenti u ON c.editore=u.id 
            GROUP BY c.id 
            ORDER BY karma DESC LIMIT 3";
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
            $comment = strip_tags($comment);
            // $comment = preg_replace('/\s+/',' ', $comment);
            $comment =  $this->connection->real_escape_string($comment);

            $query = "INSERT INTO commenti(utente,testo,contenuto) VALUES ('$user', '$comment', '$contenuto')";
            // codice per fare inject (double insert) --> OOOPS', '19'), ('9', 'Rotto
            $queryResult = mysqli_query($this->connection, $query) or null;
            return $queryResult; //Ritorna true se l'inserimento è avvenuto con successo, false altrimenti
        }

        public function addContentOpinion($contenuto,$user,$opinion)
        {
            $query = "SELECT contenuto FROM karma_contenuti WHERE $contenuto = contenuto AND $user=utente";
            $queryResult = mysqli_query($this->connection, $query) or null;

            if($queryResult)
            {
                if(mysqli_num_rows($queryResult)==0)
                    $query = "INSERT INTO karma_contenuti(contenuto,utente,valore) VALUES ('$contenuto', '$user', '$opinion')";
                else{
                    if($opinion != 0)
                        $query = "UPDATE  karma_contenuti SET valore=$opinion WHERE contenuto=$contenuto AND utente=$user";
                    else
                        $query = "DELETE FROM  karma_contenuti WHERE contenuto=$contenuto AND utente=$user";
                }

                $queryResult = mysqli_query($this->connection, $query) or null;
            }
            return $queryResult;
        }

        public function addCommentOpinion($comment,$user, $opinion)
        {
            $comment=substr($comment,2);
            $query = "SELECT commento FROM karma_commenti WHERE $comment = commento AND $user = utente";
            $queryResult = mysqli_query($this->connection, $query) or null;

            if(isset($queryResult) && $queryResult)
            {
                if(mysqli_num_rows($queryResult)==0)
                    $query = "INSERT INTO karma_commenti(commento,utente,valore) VALUES ('$comment', '$user', '$opinion')";
                else{
                    if($opinion != 0)
                        $query = "UPDATE karma_commenti SET valore=$opinion WHERE commento=$comment AND utente=$user";
                    else
                        $query = "DELETE FROM karma_commenti WHERE commento=$comment AND utente=$user";
                }

                $queryResult = mysqli_query($this->connection, $query) or die("Errore in addCommentOpinion: ".mysqli_error($this->connection));
            }
        }

        public function getContentKarma($contentid){
             $query = "SELECT SUM(valore) as karma FROM karma_contenuti WHERE $contentid = contenuto";
             $queryResult = mysqli_query($this->connection, $query) or die("Errore in getContentKarma: ".mysqli_error($this->connection));
             $karma = $queryResult->fetch_assoc();
             return $karma['karma'];
        }

        public function getUserOpinionContent($contentid, $user){
            $query = "SELECT valore FROM karma_contenuti WHERE $contentid = contenuto AND $user = utente";
            $queryResult = mysqli_query($this->connection, $query) or die("Errore in getUserOpinionContent: ".mysqli_error($this->connection));
            return $queryResult;
        }

        public function deleteContent($id)
        {
            $query = "DELETE FROM contenuti WHERE id = $id";
            $queryResult = mysqli_query($this->connection, $query) or null;
            return $queryResult; //Ritorna true se l'inserimento è avvenuto con successo, false altrimenti
        }

        public function deleteComment($comment){
            $query = "DELETE FROM karma_commenti WHERE $comment = commento";
            $queryResult = mysqli_query($this->connection, $query) or die("Errore in deleteComment: ".mysqli_error($this->connection));
            $query = "DELETE FROM commenti WHERE $comment = id";
            $queryResult = mysqli_query($this->connection, $query) or die("Errore in deleteComment: ".mysqli_error($this->connection));
        }
    };
?>