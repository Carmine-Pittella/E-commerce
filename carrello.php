<?php

require "include/template2.inc.php";
require "include/dbms.inc.php";
require_once "include/php-utils/global.php";

session_start();

global $connessione;

$main = new Template("skins/template/dtml/index_v2.html");
$body = new Template("skins/template/shopping-cart.html");
$cart_elem = new Template("skins/template/dtml/dtml_items/shopping-cartItem.html");

// tiene aggiornato il numero di oggetti presenti nei preferiti e nel carrello
require "include/php-utils/preferiti_carrello.php";


if (isset($_SESSION['auth']) && $_SESSION['auth']) {

    $userid = $_SESSION['utente']['id'];
    $tot_cart = 0;

    $res = $connessione->query("SELECT * FROM Carrello WHERE id_utente = {$userid}");
    foreach ($res as $r) {
        $r['id_prodotto'];
        $r['quantita_prodotto'];
        // quantita
        $cart_elem->setContent("QUANTITA", $r['quantita_prodotto']);

        // quantita massima impostabile
        $tmp = $connessione->query("SELECT * FROM Magazzino WHERE id_prodotto = {$r['id_prodotto']} LIMIT 1;")->fetch_all(MYSQLI_ASSOC);
        $cart_elem->setContent("Q_MAX", 5);

        // immagine
        $tmp = $connessione->query("SELECT url_immagine FROM Immagine_Prodotto WHERE id_prodotto = {$r['id_prodotto']} LIMIT 1;")->fetch_all(MYSQLI_ASSOC);
        $cart_elem->setContent("URL_IMMAGINE", _IMG_PATH . $tmp[0]['url_immagine']);

        // nome e prezzo
        $tmp = $connessione->query("SELECT * FROM Prodotto WHERE id = {$r['id_prodotto']};")->fetch_all(MYSQLI_ASSOC);
        $cart_elem->setContent("NOME_PRODOTTO", $tmp[0]['nome_prodotto']);
        $cart_elem->setContent("PREZZO_SINGOLO", $tmp[0]['prezzo']);

        // totale prodotto
        $tot = intval($r['quantita_prodotto']) * floatval($tmp[0]['prezzo']);
        $cart_elem->setContent("PREZZO_TOTALE", $tot);



        $tot_cart += $tot;





        $body->setContent("elemento_carrello", $cart_elem->get());
    }

    // totale carrello
    $body->setContent("TOTALE_PARZIALE_CARRELLO", $tot_cart);
    $body->setContent("TOTALE_CARRELLO", $tot_cart);











    //
} else {
    header("Location: login.php");
}







$main->setContent('body', $body->get());
$main->close();
