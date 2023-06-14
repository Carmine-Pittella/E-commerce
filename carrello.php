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
    $alertNeed = 0;


    $res = $connessione->query("SELECT * FROM Carrello WHERE id_utente = {$userid}");
    foreach ($res as $r) {
        $r['id_prodotto'];
        $r['quantita_prodotto'];
        $r['taglia_prodotto'];

        $magazzino = $connessione->query("SELECT * FROM Magazzino WHERE id_prodotto = {$r['id_prodotto']} AND taglia = '{$r['taglia_prodotto']}' LIMIT 1")->fetch_all(MYSQLI_ASSOC);;
        if ($magazzino[0]['quantita'] < $r['quantita_prodotto']) {

            if ($magazzino[0]['quantita'] == 0) {
                $alertNeed = 1;
            } else {
                $alertNeed = 2;
            }
        }
    }



    // QUESTO VA TUTTO ALL'INTERNO DEL FOREACH, ALTRIMENTI COME FA A PRENDERE I PARAMETRI
    // if ($alertNeed != 0) {
    //     require_once "include/php-utils/alert.php";
    //     Alert::OpenAlert("Le quantità che avevi selezionato per i  tuoi prodotti non sono più disponibili :(");

    //     switch ($alertNeed) {
    //         case 1:
    //             // rimuovere il prodotto dal carrello
    //             $rmv = $connessione->prepare("DELETE FROM Carrello WHERE id_utente = ? AND id_prodotto = ? AND taglia_prodotto = ?;");
    //             $rmv->bind_param("iis", $userid, $r['id_prodotto'], $r['taglia_prodotto']);
    //             if ($rmv->execute()) {
    //                 echo "Elemento eliminato dal Carrello.";
    //             } else {
    //                 echo "Errore durante eliminazione in Carrello: " . $rmv->error;
    //             }
    //             break;

    //         case 2:
    //             // settare la quantità di quel prodotto nel carrello con id_utente = (...) a 1
    //             $upd = $connessione->prepare("UPDATE Carrello SET quantita_prodotto = ? WHERE id_prodotto = ? AND id_utente = ? AND taglia_prodotto = ?");
    //             $upd->bind_param("iis", 1, $r['id_prodotto'], $r['taglia_prodotto']);
    //             if ($upd->execute()) {
    //                 echo "Aggiornamento tabella Carrello.";
    //             } else {
    //                 echo "Errore durante aggiornamento in Carrello: " . $upd->error;
    //             }
    //             break;
    //     }
    // }
    // QUESTO VA TUTTO ALL'INTERNO DEL FOREACH, ALTRIMENTI COME FA A PRENDERE I PARAMETRI








    //

    $res = $connessione->query("SELECT * FROM Carrello WHERE id_utente = {$userid}");
    foreach ($res as $r) {
        // id, quantita e taglia
        $cart_elem->setContent("ID_PRODOTTO", $r['id_prodotto']);
        $cart_elem->setContent("QUANTITA", $r['quantita_prodotto']);
        $cart_elem->setContent("TAGLIA_PRODOTTO", $r['taglia_prodotto']);

        // quantita massima impostabile
        $tmp = $connessione->query("SELECT * FROM Magazzino WHERE id_prodotto = {$r['id_prodotto']} AND taglia = '{$r['taglia_prodotto']}' LIMIT 1;")->fetch_all(MYSQLI_ASSOC);
        $cart_elem->setContent("Q_MAX", $tmp[0]['quantita']);

        // immagine
        $tmp = $connessione->query("SELECT url_immagine FROM Immagine_Prodotto WHERE id_prodotto = {$r['id_prodotto']} LIMIT 1;")->fetch_all(MYSQLI_ASSOC);
        $cart_elem->setContent("URL_IMMAGINE", _IMG_PATH . $tmp[0]['url_immagine']);

        // nome e prezzo
        $tmp = $connessione->query("SELECT * FROM Prodotto WHERE id = {$r['id_prodotto']};")->fetch_all(MYSQLI_ASSOC);
        $cart_elem->setContent("NOME_PRODOTTO", $tmp[0]['nome_prodotto']);
        $cart_elem->setContent("PREZZO_SINGOLO", $tmp[0]['prezzo']);

        // totale prodotto

        $body->setContent("elemento_carrello", $cart_elem->get());
    }

    // totale carrello











    //
} else {
    header("Location: login.php");
}







$main->setContent('body', $body->get());
$main->close();
