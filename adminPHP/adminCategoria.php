<?php
require "../include/template2.inc.php";
require "../include/dbms.inc.php";
global $connessione;

    //display form per la modifica della categoria
if(isset($_REQUEST['mc_id'])){

    $idC = $_REQUEST['mc_id'];
    $form = new Template("../skins/template/adminModificaCat_Mar.html");
    $form->setContent("ACTION_FORM","adminCategoria.php");
    $form->setContent("CAT_MAR","categoria");
    $form->setContent("NAME_FIELD","formCategoria");
    $form->setContent("id_mc",$_REQUEST['mc_id']);

    $res = $connessione->query("SELECT * FROM Categoria WHERE id ='$idC' ")->fetch_all(MYSQLI_ASSOC);
    $form->setContent("DEF_VAL",$res[0]['nome_categoria']);

    $form ->close();


}

//modifica effettuata
if(isset($_POST['formCategoria'])){
    $nome_cat = $_POST['formCategoria'];
    $idC = $_POST['formId'];
    
    $connessione->query("UPDATE Categoria SET nome_categoria = '$nome_cat' WHERE id = '$idC'");
    header("location:http://localhost/E-commerce/admin.php");
    exit();
    
  }
// display aggiungi una nuova marca
if(isset($_GET['add'])){
    $add_template = new Template ("../skins/template/adminAggiungiCat_Mar.html");
    $add_template->setContent("CAT_MAT", "aggiungi una nuova categoria");
    $add_template->setContent("NAME_FIELD","formAddCategoria");
    $add_template->setContent("ACTION_FORM","adminCategoria.php");
    $add_template->setContent("errore","");
    $add_template->close();
}
// aggiunta una nuova Categoria
if(isset($_POST['formAddCategoria'])){
    $nuovaCat = $_POST['formAddCategoria'];
    $res = $connessione->query("SELECT * FROM Categoria WHERE nome_categoria = '$nuovaCat'")->fetch_all(MYSQLI_ASSOC); 
    if (count($res)===0){
      $connessione->query("INSERT INTO Categoria (nome_categoria) VALUES ('$nuovaCat')");
      header("location:http://localhost/E-commerce/admin.php");
      exit();
    }else{
      // caso in cui l'elemento già esiste
      $add_template = new Template ("../skins/template/adminAggiungiCat_Mar.html");
      $add_template->setContent("CAT_MAT", "aggiungi una nuova categoria");
      $add_template->setContent("NAME_FIELD","formAddCategoria");
      $add_template->setContent("ACTION_FORM","adminCategoria.php");
      $add_template->setContent("errore",' <label style="color: red;">categoria già esistente</label>');
      $add_template->close();
    }
  
  }

//display lista Categorie
if( (!isset($_REQUEST['mc_id']))&&(!isset($_POST['NAME_FIELD']))&&(!isset($_GET['add']))&&(!isset($_POST['formAddCategoria'])) ){
    $admin_container = new Template("../skins/template/adminContainer2.html");
    $admin_container->setContent('elemento',"una nuova categoria");
    $admin_container->setContent("HREF","adminPHP/adminCategoria.php?add=1");
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





