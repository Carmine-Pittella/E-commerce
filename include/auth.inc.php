<?php


class Auth
{

    static function check()
    {
        global $mysql;

        if (!isset($_SESSION['auth'])) {

            if (!isset($_POST['email']) or !isset($_POST['password'])) {
                // apertura schermata per fare il login
                Header("Location: login.php");
                exit;
            } else {
                $result = $mysql->query("SELECT id, nome, cognome, email, password, tipologia_utente 
                    FROM Utente 
                    WHERE email = '{$_POST['email']}' AND password = MD5('{$_POST['password']}')");
                // MD5 serve per il decrypt della password tramite la password stessa

                if (!$result) {
                    // errore durante l'esecuzione della query (creare una pagine ERRORE da visualizzare)
                    header("Location: pagina di errore che non esiste al momento");
                    exit;
                }

                if ($result->num_rows == 0) {
                    // username o password errati
                    header("Location: login.php?error=2");
                    exit;
                } else {
                    $data = $result->fetch_assoc();
                    $_SESSION['auth']['Utente'] = $data;

                    $result = $mysql->query("select user.username, user_role.id_role, service.name, service.script
                        from user
                        left join user_role
                        on user_role.username = user.username
                        left join role_service
                        on role_service.id_role = user_role.id_role
                        left join service
                        on service.id = role_service.id_service
                        where user.username = '{$_POST['username']}'");

                    if (!$result) {
                        // error
                    }
                    $service = array();

                    while ($data = $result->fetch_assoc()) {
                        $service[$data['script']] = true;
                    }

                    $_SESSION['auth']['service'] = $service;

                    return true;
                }
            }
        } else {

            // user already logged

        }

        if (!isset($_SESSION['auth']['service'][basename($_SERVER['SCRIPT_FILENAME'])])) {
            Header("Location: error.php?003-permission-denied");
            exit;
        }
    }
}


Auth::check();
