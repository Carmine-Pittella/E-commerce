<?php

require "include/template2.inc.php";
require "include/dbms.inc.php";

global $connessione;

$main = new Template("skins/template/dtml/index_v2.html");
$profile = new Template("skins/template/profile.html");

// tiene aggiornato il numero di oggetti presenti nei preferiti e nel carrello
require "include/php-utils/preferiti_carrello.php";


/********* popolamento dati utente *********/
$res = $connessione->query("SELECT * FROM Utente u WHERE u.id = 1;")->fetch_all(MYSQLI_ASSOC);
foreach ($res as $r) {
    $profile->setContent("nome_utente", $r['nome']);
    $profile->setContent("cognome_utente", $r['cognome']);
    $profile->setContent("email_utente", $r['email']);
}

/********* popolamento della tabella di ordini dell'utente *********/
$res = $connessione->query("SELECT Ordine.*, Indirizzo_Spedizione.indirizzo
                            FROM Ordine
                            INNER JOIN Indirizzo_Spedizione ON Ordine.id_indirizzo_spedizione = Indirizzo_Spedizione.id
                            WHERE Ordine.id_utente = 1;
                            ")->fetch_all(MYSQLI_ASSOC);
foreach ($res as $r) {
    $ordine = new Template("skins/template/dtml/dtml_items/ordini_utente.html");
    $ordine->setContent("codice_ordine", $r['id']);
    $ordine->setContent("data_ordine", $r['data_ordine']);
    $ordine->setContent("prezzo_ordine", $r['prezzo_ordine']);
    $ordine->setContent("stato_ordine", "in preparazione");
    $ordine->setContent("indirizzo_spedizione_ordine", $r['indirizzo']);

    if ($r['data_spedizione']) {
        $data_spedizione = strtotime($r['data_spedizione']);
        if ($data_spedizione < time()) {
            $ordine->setContent("stato_ordine", "spedito");
        }
    }

    $profile->setContent("ordini_utente", $ordine->get());
}


$main->setContent('body', $profile->get());
$main->close();
