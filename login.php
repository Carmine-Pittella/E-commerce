<?php

require "include/template2.inc.php";
require "include/dbms.inc.php";

global $connessione;

$main = new Template("skins/template/dtml/index_v2.html");
$login = new Template("skins/template/login.html");

// tiene aggiornato il numero di oggetti presenti nei preferiti e nel carrello
require "include/php-utils/preferiti_carrello.php";


$main->setContent('body', $login->get());
$main->close();
/* non so perché non mi prende i css */