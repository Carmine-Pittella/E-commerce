<?php


class Auth
{

    static function check()
    {
        global $mysql;

        if (!isset($_SESSION['auth'])) {

            if (!isset($_POST['username']) or !isset($_POST['password'])) {
                Header("Location: error.php?002-username-and-password-not-entered");
                exit;
            } else {

                $result = $mysql->query("SELECT username, name, surname, email 
                    FROM user 
                    WHERE username = '{$_POST['username']}' AND password = MD5('{$_POST['password']}')");

                if (!$result) {
                    Header("Location: error.php?generic");
                    exit;
                }

                if ($result->num_rows == 0) {
                    Header("Location: error.php?001-uknown-user");
                    exit;
                } else {
                    $data = $result->fetch_assoc();
                    $_SESSION['auth']['user'] = $data;

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
