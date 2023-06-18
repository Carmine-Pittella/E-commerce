<?php

require "include/template2.inc.php";
require "include/dbms.inc.php";
require_once "include/php-utils/global.php";

session_start();

global $connessione;

$main = new Template("skins/template/dtml/index_v2.html");
$body = new Template("skins/template/dtml/home.html");

// tiene aggiornato il numero di oggetti presenti nel carrello
require "include/php-utils/preferiti_carrello.php";

// search id promozione
$res = $connessione->query("SELECT id_promozione, id_categoria FROM Prodotto WHERE id_promozione IS NOT NULL LIMIT 1;")->fetch_all(MYSQLI_ASSOC);
if (!empty($res)) {

    // categoria associata
    $cat = $connessione->query("SELECT nome_categoria FROM Categoria WHERE id = {$res[0]['id_categoria']} LIMIT 1;")->fetch_all(MYSQLI_ASSOC);
    $body->setContent("CATEGORIA_PROMOZIONE", $cat[0]['nome_categoria']);

    // promozione
    $promo = $connessione->query("SELECT * FROM Promozione WHERE id = {$res[0]['id_promozione']} LIMIT 1;")->fetch_all(MYSQLI_ASSOC);
    $body->setContent("NOME_PROMOZIONE", $promo[0]['nome_promozione']);
    $body->setContent("DESCRIZIONE_PROMOZIONE", $promo[0]['descrizione']);
    $body->setContent("SCONTO_PERCENTUALE", intval($promo[0]['sconto_percentuale']));

    $data = strtotime($promo[0]['data_fine']);
    $body->setContent("GG", date("d", $data));
    $body->setContent("MM", date("m", $data));
    $body->setContent("AAAA", date("Y", $data));
}







$main->setContent('body', $body->get());
$main->close();
