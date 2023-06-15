<?php


require "../include/template2.inc.php";
require "../include/dbms.inc.php";
global $connessione;


 //display form per la modifica della marca
 if(isset($_REQUEST['mc_id'])){
    $form = new Template("../skins/template/adminModificaCat_Mar.html");
    $form->setContent("ACTION_FORM","adminMarche");
    $form->setContent("CAT_MAR","marca");
    $form->setContent("NAME_FIELD","formMarca");
    $form->setContent("id_mc",$_REQUEST['mc_id']);

    $form ->close();


}
 
// display lista marche
if( !(isset($_REQUEST['mc_id'])) ){
    $admin_container = new Template("../skins/template/adminContainer2.html");
    $admin_container->setContent('elemento',"una nuova marca");
    $res = $connessione->query("SELECT * FROM Marca")->fetch_all(MYSQLI_ASSOC); 
    foreach($res as $r){
        $item = new Template ("../skins/template/dtml/dtml_items/marca_categoriaAdminIteam.html");
        $item->setContent("MARCA_CATEGORIA", $r['nome_marca']);
        $item->setContent("ID_MC", $r['id']);
        $item->setContent("FILE","adminMarche");
        $admin_container->setContent('item',$item->get());
    }
    $admin_container ->close();
}




/*
<div class="container">
        <form method="post" action="<[ACTION_FORM]>">
          <div class="form-group">
            <label for="ttt"><[CAT_MAR]></label>
            <input type="text" class="form-control"  name="<[NAME_FIELD]>">
          </div>
          <button type="submit" class="btn btn-primary">Invia</button>
        </form>
    </div>
*/