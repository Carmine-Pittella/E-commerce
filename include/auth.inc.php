<?php

require "include/php-utils/utility.php";


class Auth
{
    static function check()
    {
        global $connessione;

        if (!isset($_SESSION['auth'])) {

            if (!isset($_POST['email']) or !isset($_POST['password'])) {
                // apertura schermata per fare il login
                Header("Location: login.php");
                exit;
            } else {
                $pass = utility::cryptify($_POST['password']);
                $result = $connessione->query("SELECT `id`, `nome`, `cognome`, `email`, `password`
                    FROM `Utente` 
                    WHERE `email` = '{$_POST['email']}' AND `password` = '{$pass}'");

                if (!$result) {
                    // errore durante l'esecuzione della query (creare una pagine ERRORE da visualizzare)
                    /* header("Location: pagina di errore che non esiste al momento"); */
                    exit;
                }

                if ($result->num_rows == 0) {
                    // username o password errati
                    header("Location: login.php?error=2");
                    exit;
                } else {
                    echo "utente trovato";
                    $data = $result->fetch_assoc();
                    $_SESSION['auth']['Utente'] = $data;
                    // header("Location: PROFILO");

                    // // qui "carica i servizi di cui dispone l'utente che ha fatto l'accesso"
                    // $result = $connessione->query("select user.username, user_role.id_role, service.name, service.script
                    //     from user
                    //     left join user_role
                    //     on user_role.username = user.username
                    //     left join role_service
                    //     on role_service.id_role = user_role.id_role
                    //     left join service
                    //     on service.id = role_service.id_service
                    //     where user.username = '{$_POST['username']}'");




                    if (!$result) {
                        // errore durante l'esecuzione della query (creare una pagine ERRORE da visualizzare)
                        /* header("Location: pagina di errore che non esiste al momento"); */
                        exit;
                    }
                    // $service = array();

                    // while ($data = $result->fetch_assoc()) {
                    //     $service[$data['script']] = true;
                    // }
                    // $_SESSION['auth']['service'] = $service;
                    // return true;
                }
            }
        } else {

            // user already logged

        }

        // // controlla se l'utente ha l'autorizzazione per accedere alla pagina corrente del sito web.
        // if (!isset($_SESSION['auth']['service'][basename($_SERVER['SCRIPT_FILENAME'])])) {
        //     Header("Location: error.php?003-permission-denied");
        //     exit;
        // }
    }
}


Auth::check();
