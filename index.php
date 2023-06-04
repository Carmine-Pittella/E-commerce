<?php

require "include/template2.inc.php";
require "include/dbms.inc.php";


$main = new Template("skins/template/dtml/index_v2.html");
$body = new Template("skins/template/dtml/home.html");

$main->setContent("oggetti_carrello", 8);
// nel file "index_v2.html" ci sarà un riferimento a "oggetti_carrello"
// il problema attuale è che nelle altre pagine non compare il valore impostato qui


$main->setContent('body', $body->get());
$main->close();
