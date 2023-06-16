<?php

require "include/template2.inc.php";
require "include/dbms.inc.php";
require_once "include/php-utils/alert.php";

session_start();

global $connessione;

if (isset($_SESSION['auth']) && $_SESSION['auth']) {

    $main = new Template("skins/template/dtml/index_v2.html");
    $body = new Template("skins/template/check-out.html");

    // tiene aggiornato il numero di oggetti presenti nel carrello
    require "include/php-utils/preferiti_carrello.php";
















    //
} else {
    Alert::OpenAlert("Devi effettuare l'accesso", "login.php");
}







$main->setContent('body', $body->get());
$main->close();
