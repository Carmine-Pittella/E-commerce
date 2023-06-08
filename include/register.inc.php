<?php
require "dbms.inc.php";
require "php-utils/utility.php";


function register($credenziali)
{
    global  $connessione;

    $nome = $credenziali[0];
    $cognome = $credenziali[1];
    $email = $credenziali[2];
    $password  = utility::cryptify($credenziali[3]); // crypt password


    $utente_exist = $connessione->query("SELECT * FROM Utente WHERE email = '$email'")->fetch_assoc();

    if ($utente_exist) {
        // utente gia esistente
        header("location: register.php?error=1");
    } else {
        $oid = $connessione->prepare("INSERT INTO Utente (`nome`, `cognome`, `email`, `password`)
                                    VALUES (?, ?, ?, ?)");
        $oid->bind_param("ssss", $nome, $cognome, $email, $password);

        if ($oid->execute()) {
            $user_data = $connessione->query("SELECT * FROM Utente 
                                  WHERE email = '$email'
                                  AND password = '$password'")->fetch_array(MYSQLI_ASSOC);
            if (!$user_data) {
                // qualcosa è andato storto 
                header("location: register.php?error=2");
                exit();
            }

            session_start();
            $_SESSION['utente'] = $user_data;
            $_SESSION['auth'] = true;


            echo "<script> console.log('Registrazione avvenuta con successo') </script>";
            // header("location: register.php?error=");
            // bisogna fare un sistema di alert che dice se la registrazione è avvenuta con successo
        }
    }
}
