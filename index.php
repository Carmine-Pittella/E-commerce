<?php

require "include/template2.inc.php";
require "include/dbms.inc.php";

session_start();

global $connessione;

$main = new Template("skins/template/dtml/index_v2.html");
$body = new Template("skins/template/dtml/home.html");

// tiene aggiornato il numero di oggetti presenti nel carrello
require "include/php-utils/preferiti_carrello.php";

// search id promozione
$res = $connessione->query("SELECT id_promozione, id_categoria FROM Prodotto WHERE id_promozione IS NOT NULL LIMIT 1;")->fetch_all(MYSQLI_ASSOC);
$idPromo = $res[0]['id_promozione'];
$idCateg = $res[0]['id_categoria'];

// promozione
$res = $connessione->query("SELECT * FROM Promozione WHERE id = {$idPromo} LIMIT 1;")->fetch_all(MYSQLI_ASSOC);
$res[0]['nome_promozione'];
$res[0]['descrizione'];
$res[0]['sconto_percentuale'];
$res[0]['data_fine'];

// categoria associata
$res = $connessione->query("SELECT nome_categoria FROM Categoria WHERE id = {$idCateg} LIMIT 1;")->fetch_all(MYSQLI_ASSOC);
$res[0]['nome_categoria'];




$main->setContent('body', $body->get());
$main->close();
