<?php
     //1) Se avessi scritto direttamente su htaccess i percorsi non sarebbero stati corretti sui css (percorsi relativi)
     //subfolders diversi -> percorsi per arrivare al errore404 diversi e quindi serve un percorso da root
     header("Location: /Pokemon/errore404.html");
?>