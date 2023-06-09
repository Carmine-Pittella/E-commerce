<?php

const BLANK_T = "";

require "include/template2.inc.php";
require "include/dbms.inc.php";


$main = new Template("skins/template/dtml/index_v2.html");
$login = new Template("skins/template/login.html");

// tiene aggiornato il numero di oggetti presenti nei preferiti e nel carrello
require "include/php-utils/preferiti_carrello.php";


//in caso di errore in autenticazione, l'URL si modifica e la "variabile" 'error' viene presa da lì
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 1:
            $error = "Compila tutti i campi!";
            break;
        case 2:
            $error = "Username e/o password errati !";
            echo "<script>alert(`$error`); window.setTimeout(function() {
                    window.location.href = 'login.php';
                    }, 0);</script>";
            break;
    }
    session_abort();
    $login->setContent("error", $error);
} else {
    $login->setContent("error", BLANK_T);
}


$main->setContent('body', $login->get());



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        !isset($_POST['email']) || $_POST['email'] == '' ||
        !isset($_POST['password']) || $_POST['password'] == ''
    ) {
        header("Location: login.php?error=1");
    } else {
        require_once('include/auth.inc.php');
        // questo file ha le funzioni per gestire l'accesso in generale
    }
}



$main->close();
