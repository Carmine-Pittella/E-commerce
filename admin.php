<?php
    require "include/template2.inc.php";
    require "include/dbms.inc.php";
    global $connessione;

    $admin_home = new Template("skins/template/admin-home.html");
    $admin_container = new Template("skins/template/adminContainer.html");

    $filtri = new Template ("skins/template/dtml/filtri_laterali.html");
    $admin_container = setFiltri($filtri,$connessione,$admin_container);

    $res = $connessione->query("SELECT * FROM Prodotto")->fetch_all(MYSQLI_ASSOC);
    $admin_container=setItems($res,$connessione,$admin_container);
    

    $admin_home->setContent('body', $admin_container->get());
    $admin_home->close();



    function setFiltri($filtri,$connessione,$admin_container){
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
        $admin_container->setContent('filter', $filtri->get());
        return $admin_container;
    }

    function setItems($res,$connessione,$admin_container){
        foreach ($res as $r) {
            $prodotto = new Template("skins/template/dtml/dtml_items/prodottoAdminItem.html");
            $marcaTmp = $connessione->query("SELECT m.nome_marca FROM prodotto p LEFT JOIN marca m ON $r[id_marca] = m.id;")->fetch_all(MYSQLI_ASSOC);
            $prodotto->setContent("MARCA_PRODOTTO", $marcaTmp[0]['nome_marca']);
            $prodotto->setContent("NOME_PRODOTTO", $r['nome_prodotto']);
            $prodotto->setContent("ID_PRODOTTO", $r['id']);
            $admin_container->setContent('item', $prodotto->get());
        }
        return $admin_container;
    }