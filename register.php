<?php

const BLANK_T = "";

require "include/template2.inc.php";
// require "include/dbms.inc.php"; tanto questo viene chiamato in register.inc.php
require "include/register.inc.php";


$main = new Template("skins/template/dtml/index_v2.html");
$register = new Template("skins/template/register.html");

// tiene aggiornato il numero di oggetti presenti nei preferiti e nel carrello
require "include/php-utils/preferiti_carrello.php";



if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 1:
            $error = "Utente già esistente!";
            echo "<script>alert(`$error`); window.setTimeout(function() {
                    window.location.href = 'register.php';
                    }, 0);</script>";
            break;
        case 2:
            $error = "Ops! qualcosa è andato storto :(";
            echo "<script>alert(`$error`); window.setTimeout(function() {
                    window.location.href = 'register.php';
                    }, 0);</script>";
            break;
        case 3:
            $error = "Registrazione avvenuta con successo";
            echo "<script>alert(`$error`); window.setTimeout(function() {
                    window.location.href = 'register.php';
                    }, 0);</script>";
            break;
    }
    $register->setContent("error", $error);
} else {
    $register->setContent("error", BLANK_T);
}

$main->setContent('body', $register->get());

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // if (isset($_POST['nome'])) {
    echo "<script> console.log('POST') </script>";
    if (
        isset($_POST['nome']) ||
        isset($_POST['cognome']) ||
        isset($_POST['email']) ||
        isset($_POST['password'])
    ) {
        register([$_POST['nome'], $_POST['cognome'], $_POST['email'], $_POST['password']]);
    }
}

$main->close();
