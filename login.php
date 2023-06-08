<?php

require "include/template2.inc.php";
require "include/dbms.inc.php";

global $connessione;

/* distinguo due casi 
1) quando viene chiamata per eseguire l'autenticazine
2) quando login.php viene chiamata per il display della pagina
*/
if(isset($_POST['username'])){
    /* eseguo l'autenticazione */

}
else{
    $main = new Template("skins/template/login.html");
    $main->close();
/* non so perché non mi prende i css */
}

