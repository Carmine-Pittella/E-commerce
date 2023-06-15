<?php

require "include/dbms.inc.php";
require "include/template2.inc.php";

session_start();
global $connessione;


$main = new Template("skins/template/dtml/index_v2.html");
$body = new Template("skins/template/order-details.html");

if (isset($_SESSION['auth']) && $_SESSION['auth']) {
    // utente autenticato
    // $userid = $_SESSION['utente']['id'];

    // $res = $connessione->query("SELECT * FROM Ordine WHERE id_utente = $userid")->fetch_all(MYSQLI_ASSOC);
    // foreach ($res as $r) {
    //     $ordine = new Template("skins/template/dtml/dtml_items/dettagli-ordineItem.html");





    // }


    // foto, nome, codice, prezzo, quantita, corriere, metodo pagamento, 








    //
} else {
    header("Location: login.php");
}


$main->setContent('body', $body->get());
$main->close();
