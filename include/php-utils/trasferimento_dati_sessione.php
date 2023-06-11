<?php

// session_start();

if (isset($_SESSION['carrello'])) {
    // travasamento
    $prod_gia_presente = false;

    $res = $connessione->query("SELECT * FROM Carrello WHERE id_utente = {$_SESSION['utente']['id']}")->fetch_all(MYSQLI_ASSOC);

    foreach ($_SESSION['carrello'] as &$cart_elem) {
        $prod_gia_presente = false;
        foreach ($res as $r) {
            if ($cart_elem['id_prodotto'] == $r['id_prodotto']) {
                // sommo
                $quantita_attuale = intval($r['quantita_prodotto']);
                $nuova_quantita = $quantita_attuale + intval($cart_elem['id_prodotto']);

                $upd = $connessione->prepare("UPDATE Carrello SET quantita_prodotto = ? WHERE id_prodotto = ?");
                $upd->bind_param("ii", $nuova_quantita, $r['id_prodotto']);
                if ($upd->execute()) {
                    echo "Aggiornamento tabella Carrello.";
                } else {
                    echo "Errore durante aggiornamento in Carrello: " . $upd->error;
                }
                $prod_gia_presente = true;
                break;
            }
        }
        if (!$prod_gia_presente) {
            // aggiungo
            $add = $connessione->prepare("INSERT INTO Carrello (id_utente, id_prodotto, quantita_prodotto) VALUES (?, ?, ?)");
            $add->bind_param("iii", $_SESSION['utente']['id'], $cart_elem['id_prodotto'], $cart_elem['quantita']);
            if ($add->execute()) {
                echo "Aggiunta tabella Carrello.";
            } else {
                echo "Errore durante aggiunta tabella Carrello: " . $add->error;
            }
        }
    }
    // distruggo il carrello in sessione
    unset($_SESSION['carrello']);
}
