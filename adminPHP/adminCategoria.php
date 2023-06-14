<?php
require "../include/template2.inc.php";
require "../include/dbms.inc.php";
global $connessione;

$admin_container = new Template("../skins/template/adminContainer2.html");
$admin_container->setContent('elemento',"una nuova categoria");
$res = $connessione->query("SELECT * FROM Categoria")->fetch_all(MYSQLI_ASSOC); 
foreach($res as $r){
    $item = new Template ("../skins/template/dtml/dtml_items/marca_categoriaAdminIteam.html");
    $item->setContent("MARCA_CATEGORIA", $r['nome_categoria']);
    $item->setContent("ID_MC", $r['id']);
    $admin_container->setContent('item',$item->get());
    
}

$admin_container ->close();


