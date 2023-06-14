<?php

require "include/template2.inc.php";
require "include/dbms.inc.php";

session_start();

global $connessione;

$main = new Template("skins/template/dtml/index_v2.html");
$body = new Template("skins/template/shopping-cart.html");

// tiene aggiornato il numero di oggetti presenti nel carrello
require "include/php-utils/preferiti_carrello.php";


if (isset($_SESSION['auth']) && $_SESSION['auth']) {

    $main = new Template("skins/template/dtml/index_v2.html");
    $body = new Template("skins/template/check-out.html");

    // tiene aggiornato il numero di oggetti presenti nel carrello
    require "include/php-utils/preferiti_carrello.php";
















    //
} else {
    header("Location: login.php");
}







$main->setContent('body', $body->get());
$main->close();
