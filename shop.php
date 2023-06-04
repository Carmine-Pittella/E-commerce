<?php

require "include/template2.inc.php";
require "include/dbms.inc.php";

global $connessione;

$main = new Template("skins/template/dtml/index_v2.html");
$shop = new Template("skins/template/shop.html");


$res = $connessione->query("SELECT * FROM categoria c ORDER BY c.nome_categoria")->fetch_all(MYSQLI_ASSOC);

foreach ($res as $r) {
    $nome = new Template("skins/template/dtml/dtml_items/provanome.html");
    $nome->setContent("NOME_CATEGORIA", $r['nome_categoria']);
    $shop->setContent("categorie", $nome->get());
}


$main->setContent('body', $shop->get());
$main->close();
