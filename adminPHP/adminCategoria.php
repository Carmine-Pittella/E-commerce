<?php
require "../include/template2.inc.php";
require "../include/dbms.inc.php";
global $connessione;

    //display form per la modifica della categoria
if(isset($_REQUEST['mc_id'])){
    $form = new Template("../skins/template/adminModificaCat_Mar.html");
    $form->setContent("ACTION_FORM","adminCategoria");
    $form->setContent("CAT_MAR","categoria");
    $form->setContent("NAME_FIELD","formCategoria");
    $form->setContent("id_mc",$_REQUEST['mc_id']);

    $form ->close();


}

//display lista Categorie
if( !(isset($_REQUEST['mc_id'])) ){
    $admin_container = new Template("../skins/template/adminContainer2.html");
    $admin_container->setContent('elemento',"una nuova categoria");
    $res = $connessione->query("SELECT * FROM Categoria")->fetch_all(MYSQLI_ASSOC); 
    foreach($res as $r){
        $item = new Template ("../skins/template/dtml/dtml_items/marca_categoriaAdminIteam.html");
        $item->setContent("MARCA_CATEGORIA", $r['nome_categoria']);
        $item->setContent("ID_MC", $r['id']);
        $item->setContent("FILE","adminCategoria");
        $admin_container->setContent('item',$item->get());
        
    }
    $admin_container ->close();
}





