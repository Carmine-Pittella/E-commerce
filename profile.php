<?php

require "include/template2.inc.php";
require "include/dbms.inc.php";


$main = new Template("skins/template/dtml/index_v2.html");
$profile = new Template("skins/template/profile.html");

// tiene aggiornato il numero di oggetti presenti nei preferiti e nel carrello
require "include/php-utils/preferiti_carrello.php";


$main->setContent('body', $profile->get());
$main->close();
