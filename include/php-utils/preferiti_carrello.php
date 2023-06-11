<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// tiene aggiornato il numero di oggetti presenti nei preferiti e nel carrello
$cart = new Template("skins/template/dtml/dtml_items/main/icona_carrello.html");
$cart_items = 0;


if (isset($_SESSION['auth']) && $_SESSION['auth']) {
    // utente autenticato -- contare dalla query


} else {
    // utente non autenticato -- contare dalla sessione
    if (isset($_SESSION['carrello'])) {
        $cart_items = count($_SESSION['carrello']);
    }
}



$cart->setContent('oggetti_carrello', $cart_items);
$main->setContent('carrello_icon', $cart->get());
