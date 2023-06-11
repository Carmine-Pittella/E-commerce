<?php

require_once "include/php-utils/global.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// tiene aggiornato il numero di oggetti presenti nei preferiti e nel carrello
$cart = new Template("skins/template/dtml/dtml_items/main/icona_carrello.html");
$lista_carrello = new Template("skins/template/dtml/dtml_items/main/prodotti_lista_cart.html");
$cart_items = 0;
$totale_cart = 0.0;


if (isset($_SESSION['auth']) && $_SESSION['auth']) {
    // utente autenticato -- contare dalla query
    $res = $connessione->query("SELECT * FROM Carrello WHERE id_utente = {$_SESSION['utente']['id']}")->fetch_all(MYSQLI_ASSOC);

    foreach ($res as $r) {
        // quantita prodotto

        // nome prodotto



    }
} else {
    // utente non autenticato -- contare dalla sessione
    if (isset($_SESSION['carrello'])) {
        $cart_items = count($_SESSION['carrello']);
        foreach ($_SESSION['carrello'] as &$cart_elem) {

            $lista_carrello->setContent('QUANTITA_PROD', $cart_elem['quantita']);

            $res = $connessione->query("SELECT * FROM Prodotto WHERE id = {$cart_elem['id_prodotto']}")->fetch_all(MYSQLI_ASSOC);
            $lista_carrello->setContent('NOME_PROD', $res[0]['nome_prodotto']);
            $lista_carrello->setContent('PREZZO_PROD', $res[0]['prezzo']);

            $prezzo_cart_elem = floatval($res[0]['prezzo']) * intval($cart_elem['quantita']);
            $totale_cart += $prezzo_cart_elem;

            $url_img = $connessione->query("SELECT url_immagine FROM Immagine_Prodotto WHERE id_prodotto = {$res[0]['id']} LIMIT 1;")->fetch_all(MYSQLI_ASSOC);
            $lista_carrello->setContent('IMMAGINE_PROD', _IMG_PATH . $url_img[0]['url_immagine']);


            $cart->setContent('lista_prodotti', $lista_carrello->get());

            // IO NON CAPISCO PERCHE COMPARE SEMPRE LO STESSO PRODOTTO NELLA GRAFICA PORCAMADONNA
        }
    }
}

$cart->setContent('TOTALE_CART', $totale_cart);

$cart->setContent('oggetti_carrello', $cart_items);
$main->setContent('carrello_icon', $cart->get());
