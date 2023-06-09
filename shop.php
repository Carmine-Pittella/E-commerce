<?php

require "include/template2.inc.php";
require "include/dbms.inc.php";






/******* caso chiamata POST per filtri  *******/
if (isset($_POST['valore'])) {
    $v = $_POST['valore'];
    
    /****  caso filtri per categoria****/
    if($v['tipo']==="categoria"){
        $categoria_selezionata = $v['valore'];
        $res = $connessione->query("SELECT *FROM Prodotto WHERE id_categoria = (SELECT id FROM Categoria WHERE nome_categoria = '$categoria_selezionata');")->fetch_all(MYSQLI_ASSOC);
        foreach ($res as $r) {
            $marcaTmp = $connessione->query("SELECT m.nome_marca FROM prodotto p LEFT JOIN marca m ON $r[id_marca] = m.id;")->fetch_all(MYSQLI_ASSOC);
            $prodotto = new Template("skins/template/dtml/dtml_items/prodottoShopItem.html");
            $prodotto->setContent("NOME_PRODOTTO", $r['nome_prodotto']);
            $prodotto->setContent("MARCA_PRODOTTO", $marcaTmp[0]['nome_marca']);

            if ($r['id_promozione']) {
                // devo impostare il vecchio prezzo e calcolare il nuovo
                $prodotto->setContent("PREZZO_PRODOTTO_PRECEDENTE", $r['prezzo']);
                $promo = $connessione->query("SELECT prom.sconto_percentuale FROM prodotto p LEFT JOIN promozione prom ON $r[id_promozione] = prom.id")->fetch_all(MYSQLI_ASSOC);
                $sconto = intval($promo[0]['sconto_percentuale']);
                $nuovoPrezzo = intval($r['prezzo']) - ($sconto * intval($r['prezzo']) / 100);

                $prodotto->setContent("PREZZO_PRODOTTO", $nuovoPrezzo);
            } else {
                $prodotto->setContent("PREZZO_PRODOTTO", $r['prezzo']);
            }
            echo $prodotto->get();
        }
    }else{
        $res = $connessione->query("SELECT * FROM prodotto")->fetch_all(MYSQLI_ASSOC);
        foreach ($res as $r) {
            $marcaTmp = $connessione->query("SELECT m.nome_marca FROM prodotto p LEFT JOIN marca m ON $r[id_marca] = m.id;")->fetch_all(MYSQLI_ASSOC);
            $prodotto = new Template("skins/template/dtml/dtml_items/prodottoShopItem.html");
            $prodotto->setContent("NOME_PRODOTTO", $r['nome_prodotto']);
            $prodotto->setContent("MARCA_PRODOTTO", $marcaTmp[0]['nome_marca']);

            if ($r['id_promozione']) {
                // devo impostare il vecchio prezzo e calcolare il nuovo
                $prodotto->setContent("PREZZO_PRODOTTO_PRECEDENTE", $r['prezzo']);
                $promo = $connessione->query("SELECT prom.sconto_percentuale FROM prodotto p LEFT JOIN promozione prom ON $r[id_promozione] = prom.id")->fetch_all(MYSQLI_ASSOC);
                $sconto = intval($promo[0]['sconto_percentuale']);
                $nuovoPrezzo = intval($r['prezzo']) - ($sconto * intval($r['prezzo']) / 100);

                $prodotto->setContent("PREZZO_PRODOTTO", $nuovoPrezzo);
            } else {
                $prodotto->setContent("PREZZO_PRODOTTO", $r['prezzo']);
            }
            echo $prodotto->get();
        }
        
    }


}else{
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
        $filtri->setContent("categorie", $categoria->get());
    }

    $res = $connessione->query("SELECT * FROM marca m ORDER BY m.nome_marca")->fetch_all(MYSQLI_ASSOC);
    foreach ($res as $r) {
        $marca = new Template("skins/template/dtml/dtml_items/barra laterale filtri/marcaItem.html");
        $marca->setContent("NOME_MARCA", $r['nome_marca']);
        $filtri->setContent('marche', $marca->get());
    }

    $shop->setContent('sezione_filtri', $filtri->get());

    /********* popolamento dei prodotti *********/

    $res = $connessione->query("SELECT * FROM prodotto")->fetch_all(MYSQLI_ASSOC);
    foreach ($res as $r) {
        $marcaTmp = $connessione->query("SELECT m.nome_marca FROM prodotto p LEFT JOIN marca m ON $r[id_marca] = m.id;")->fetch_all(MYSQLI_ASSOC);

        $prodotto = new Template("skins/template/dtml/dtml_items/prodottoShopItem.html");
        $prodotto->setContent("NOME_PRODOTTO", $r['nome_prodotto']);
        $prodotto->setContent("MARCA_PRODOTTO", $marcaTmp[0]['nome_marca']);

        if ($r['id_promozione']) {
            // devo impostare il vecchio prezzo e calcolare il nuovo
            $prodotto->setContent("PREZZO_PRODOTTO_PRECEDENTE", $r['prezzo']);
            $promo = $connessione->query("SELECT prom.sconto_percentuale FROM prodotto p LEFT JOIN promozione prom ON $r[id_promozione] = prom.id")->fetch_all(MYSQLI_ASSOC);
            $sconto = intval($promo[0]['sconto_percentuale']);
            $nuovoPrezzo = intval($r['prezzo']) - ($sconto * intval($r['prezzo']) / 100);

            $prodotto->setContent("PREZZO_PRODOTTO", $nuovoPrezzo);
        } else {
            $prodotto->setContent("PREZZO_PRODOTTO", $r['prezzo']);
        }

        $shop->setContent('prodotti', $prodotto->get());
    }

    $main->setContent('body', $shop->get());
    $main->close();

}









