<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_prodotto = $_POST['id_prodotto'];
    $quantita = $_POST['quantita'];

    // Esempio di aggiunta dei dati a una sessione
    session_start();





    $_SESSION['carrello'][] = array(
        'quantita' => $quantita,
        'id_prodotto' => $id_prodotto
    );

    // Esempio di risposta JSON
    $response = array(
        'success' => true,
        'message' => $id_prodotto
    );
    echo json_encode($response);
}
