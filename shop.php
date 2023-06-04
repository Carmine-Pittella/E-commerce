<?php

require "include/template2.inc.php";
require "include/dbms.inc.php";

global $connessione;

$main = new Template("skins/template/dtml/index_v2.html");
$shop = new Template("skins/template/shop.html");
$filtri = new Template("skins/template/dtml/filtri_laterali.html");


// tiene aggiornato il numero di oggetti presenti nei preferiti e nel carrello
require "include/php-utils/preferiti_carrello.php";


/********* popolamento della colonna laterale dei filtri *********/
$res = $connessione->query("SELECT * FROM categoria c ORDER BY c.nome_categoria")->fetch_all(MYSQLI_ASSOC);
foreach ($res as $r) {
    $categoria = new Template("skins/template/dtml/dtml_items/barra laterale filtri/categoriaItem.html");
    $categoria->setContent("NOME_CATEGORIA", $r['nome_categoria']);
    $categoria->setContent("lallero", $r['id']);
    $filtri->setContent("categorie", $categoria->get());
}


$res = $connessione->query("SELECT * FROM marca m ORDER BY m.nome_marca")->fetch_all(MYSQLI_ASSOC);
foreach ($res as $r) {
    $marca = new Template("skins/template/dtml/dtml_items/barra laterale filtri/marcaItem.html");
    $marca->setContent("NOME_MARCA", $r['nome_marca']);
    $filtri->setContent('marche', $marca->get());
}

$res = $connessione->query("SELECT * FROM colore")->fetch_all(MYSQLI_ASSOC);
foreach ($res as $r) {
    $colore = new Template("skins/template/dtml/dtml_items/barra laterale filtri/coloreItem.html");
    $colore->setContent("NOME_COLORE", $r['nome_colore']);
    $colore->setContent("CODICE_COLORE", $r['codice_colore']);
    $filtri->setContent('colori', $colore->get());
}



$shop->setContent('sezione_filtri', $filtri->get());

/********* popolamento della colonna laterale dei filtri *********/




$main->setContent('body', $shop->get());
$main->close();
