<?php
    require "include/template2.inc.php";
    require "include/dbms.inc.php";
    global $connessione;

    $admin_home = new Template("skins/template/admin-home.html");
    $admin_home->close();