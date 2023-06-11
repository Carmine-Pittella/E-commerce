<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_prodotto = $_POST['id_prodotto'];
    $quantita = $_POST['quantita'];

    // Esempio di aggiunta dei dati a una sessione
    session_start();

    if (isset($_SESSION['auth']) && $_SESSION['auth']) {
        // utente autenticato
        echo json_encode("autenticato");
    } else {
        // aggiungere tutto in sessione
        if (isset($_SESSION['carrello'])) {
            echo json_encode("carrello stettato");
            $a = $_SESSION['carrello'][0];
            echo json_encode($a);
        } else {
            echo json_encode("carrello non stettato");
        }


        echo json_encode("non autenticato");
        $_SESSION['carrello'][] = array(
            'id_prodotto' => $id_prodotto,
            'quantita' => $quantita
        );
    }





    // Esempio di risposta JSON
    $response = array(
        'success' => true,
        'message' => $id_prodotto
    );
    echo json_encode($response);
}
