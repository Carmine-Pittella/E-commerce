<?php


require "../include/template2.inc.php";
require "../include/dbms.inc.php";
global $connessione;

$admin_container = new Template("../skins/template/adminContainer2.html");
$admin_container->setContent('elemento',"una nuova marca");
$res = $connessione->query("SELECT * FROM Marca")->fetch_all(MYSQLI_ASSOC); 
foreach($res as $r){
    $item = new Template ("../skins/template/dtml/dtml_items/marca_categoriaAdminIteam.html");
    $item->setContent("MARCA_CATEGORIA", $r['nome_marca']);
    $item->setContent("ID_MC", $r['id']);
    $admin_container->setContent('item',$item->get());
    
}

$admin_container ->close();