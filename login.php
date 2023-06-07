<?php

require "include/template2.inc.php";
require "include/dbms.inc.php";

global $connessione;

$main = new Template("skins/template/login.html");
$main->close();
/* non so perché non mi prende i css */