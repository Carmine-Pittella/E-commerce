<?php

require "include/template2.inc.php";
require "include/dbms.inc.php";


$main = new Template("skins/template/dtml/index_v2.html");
$body = new Template("skins/template/dtml/home.html");

require "include/php-utils/preferiti_carrello.php";

$main->setContent('body', $body->get());
$main->close();
