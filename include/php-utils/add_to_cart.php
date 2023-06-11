<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_prodotto = $_POST['id_prodotto'];
    $quantita = $_POST['quantita'];

    // Esempio di aggiunta dei dati a una sessione
    session_start();
    // session_unset();
    // session_destroy();

    if (isset($_SESSION['auth']) && $_SESSION['auth']) {
        // utente autenticato
        echo json_encode("autenticato");
        // fare il travaso, distruggere la sessione SOLO di carrello
    } else {
        // aggiungere tutto in sessione
        echo json_encode("non autenticato");
        if (!isset($_SESSION['carrello'])) {
            // setto il carrello in sessione
            echo json_encode("carrello non stettato");
            $_SESSION['carrello'][] = array();
        }

        $a = $_SESSION['carrello'];
        echo json_encode($a);



        $_SESSION['carrello'][] = array(
            'id_prodotto' => $id_prodotto,
            'quantita' => $quantita
        );
        $a = $_SESSION['carrello'];
        echo json_encode($a);
    }
}
