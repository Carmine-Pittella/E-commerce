<?php


require "../include/template2.inc.php";
require "../include/dbms.inc.php";
global $connessione;

$modMagazzino = new Template("../skins/template/adminModificaMagazzino.html");
$modMagazzino->close();