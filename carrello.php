<?php

require "include/template2.inc.php";
require "include/dbms.inc.php";

session_start();

global $connessione;

$main = new Template("skins/template/dtml/index_v2.html");
$body = new Template("skins/template/shopping-cart.html");

// tiene aggiornato il numero di oggetti presenti nei preferiti e nel carrello
require "include/php-utils/preferiti_carrello.php";


if (isset($_SESSION['auth']) && $_SESSION['auth']) {

    // prendere tutti gli elementi del carrello con id_utente
    $userid = $_SESSION['utente']['id'];

    $res = $connessione->query("SELECT * FROM Carrello WHERE id_utente = {$userid}");
    foreach ($res as $r) {
        $r['id_prodotto'];
        $r['quantita'];
    }













    //
} else {
    header("Location: login.php");
}







$main->setContent('body', $body->get());
$main->close();