<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_prodotto = $_POST['id_prodotto'];
    $quantita = $_POST['quantita'];

    echo $id_prodotto;
    echo " " . $quantita;


    if (isset($_SESSION['auth']) && $_SESSION['auth']) {
        // aggiungere tutto sul DB













        // fine
    } else {
        // aggiungere tutto in sessione
        $prod_gia_presente = false;
        if (isset($_SESSION['carrello'])) {
            foreach ($_SESSION['carrello'] as &$cart_elem) {
                if ($cart_elem['id_prodotto'] == $id_prodotto) {
                    // aggiorno la quantita
                    $prod_gia_presente = true;
                    $nuova_quantita = intval($cart_elem['quantita']) + intval($quantita);
                    $cart_elem['quantita'] = $nuova_quantita;
                    break;
                }
            }

            if (!$prod_gia_presente) {
                // lo aggiungo
                $_SESSION['carrello'][] = array(
                    'id_prodotto' => $id_prodotto,
                    'quantita' => $quantita
                );
            }
        } else {
            // lo aggiungo
            $_SESSION['carrello'][] = array(
                'id_prodotto' => $id_prodotto,
                'quantita' => $quantita
            );
        }



        // $a = $_SESSION['carrello'];
        // echo json_encode($a);
    }
}
