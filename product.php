<?php

require "include/template2.inc.php";
require "include/dbms.inc.php";
require_once "include/php-utils/global.php";

global $connessione;
$product_id;

$main = new Template("skins/template/dtml/index_v2.html");
$body = new Template("skins/template/product.html");

// tiene aggiornato il numero di oggetti presenti nei preferiti e nel carrello
require "include/php-utils/preferiti_carrello.php";


// recupero l'id del prodotto dall'URL
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
} else {
    header('location: shop.php');
}


/********* popolamento rullino foto *********/
$res = $connessione->query("SELECT url_immagine FROM Immagine_Prodotto WHERE id_prodotto = {$product_id};")->fetch_all(MYSQLI_ASSOC);
$save_first = false;
foreach ($res as $r) {
    if (!$save_first) {
        $body->setContent("FOTO_PRINCIPALE_PRODOTTO", $_GLOBALS['_IMG_PATH'] . $r['url_immagine']);
        $save_first = true;
    }
    $rullino_foto = new Template("skins/template/dtml/dtml_items/SequenzaFotoItem.html");
    $rullino_foto->setContent("URL_IMMAGINE", $_GLOBALS['_IMG_PATH'] . $r['url_immagine']);
}
$body->setContent("RULLINO_FOTO", $rullino_foto->get());



/********* popolamento dati Prodotto *********/
$res = $connessione->query("SELECT * FROM Prodotto p WHERE p.id = {$product_id}")->fetch_all(MYSQLI_ASSOC);
foreach ($res as $r) {
    $body->setContent("NOME_PRODOTTO", $r['nome_prodotto']);
    $body->setContent("DESCRIZIONE_PRODOTTO", $r['descrizione']);

    // prezzo in promozione
    if ($r['id_promozione']) {
        $body->setContent("PREZZO_PRODOTTO_PRECEDENTE", $r['prezzo']);
        $promo = $connessione->query("SELECT prom.sconto_percentuale FROM prodotto p LEFT JOIN promozione prom ON $r[id_promozione] = prom.id")->fetch_all(MYSQLI_ASSOC);
        $sconto = intval($promo[0]['sconto_percentuale']);
        $nuovoPrezzo = intval($r['prezzo']) - ($sconto * intval($r['prezzo']) / 100);
        $body->setContent("PREZZO_PRODOTTO", $nuovoPrezzo);
    } else {
        $body->setContent("PREZZO_PRODOTTO", $r['prezzo']);
    }

    $categoria = $connessione->query("SELECT c.nome_categoria FROM Prodotto p JOIN Categoria c ON {$r['id_categoria']} = c.id")->fetch_all(MYSQLI_ASSOC);
    $body->setContent("CATEGORIA_PRODOTTO", $categoria[0]['nome_categoria']);

    $marca = $connessione->query("SELECT m.nome_marca FROM Prodotto p JOIN Marca m ON {$r['id_marca']} = m.id")->fetch_all(MYSQLI_ASSOC);
    $body->setContent("MARCA_PRODOTTO", $marca[0]['nome_marca']);
}














$main->setContent('body', $body->get());
$main->close();
