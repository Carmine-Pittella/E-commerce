<?php
require "../include/template2.inc.php";
require "../include/dbms.inc.php";
global $connessione;

if (isset($_SESSION['admin']) && $_SESSION['admin']) {
// display per l'applicazione di una promo
if(isset($_GET['prom_id'])){
    $page = new Template("../skins/template/adminPromozioni.html");
    $idPromo = $_GET['prom_id'];
    
   ////popola categorie
   $res = $connessione->query("SELECT * FROM Categoria")->fetch_all(MYSQLI_ASSOC);
   $tot = "";
   foreach($res as $r){
        $str = $r['nome_categoria'];
        $str = '<option value="'.$str.'">'.$str."</option>";
        $tot = $tot.$str;
    }
    $page->setContent("select_categoria",$tot);
    $page->setContent("form_id_prom",$idPromo);
    $page->close();
}
// rimuovere una promo
if(isset($_GET['prom_idDlt'])){
    $idPromo = $_GET['prom_idDlt'];
    $res = $connessione->query("SELECT * FROM Prodotto WHERE id_promozione = $idPromo")->fetch_all(MYSQLI_ASSOC);
    foreach($res as $r){
        $res2 = $connessione->query("UPDATE Prodotto SET id_promozione = NULL ");
    }
    // redirect 
    header("location:http://localhost/E-commerce/admin.php");
    exit();



}
//applicazione di una prova, selezionata una categoria
if(isset($_POST['formCategoria'])){
    $cat = $_POST['formCategoria'];
    $idPromo = $_POST['formIDProm'];

    //echo "<script>console.log('$cat')</script>";
    
    $res = $connessione->query("SELECT id FROM Categoria WHERE nome_categoria = '$cat'")->fetch_all(MYSQLI_ASSOC);
    $cat = $res[0]['id'];
    $res = $connessione->query("SELECT * FROM Prodotto WHERE id_categoria =  $cat")->fetch_all(MYSQLI_ASSOC);
    foreach($res as $r){
        $idProduct = $r['id'];
        $res2 = $connessione->query("UPDATE Prodotto SET id_promozione = '$idPromo' WHERE id = '$idProduct'");
    }
    // redirect 
    header("location:http://localhost/E-commerce/admin.php");
    exit();
    

}
// display lista promozioni
if( (!isset($_GET['prom_id']))&&(!isset($_GET['prom_idDlt']))&&(!isset($_POST['formCategoria'])) ){
    $admin_container2 = new Template("../skins/template/adminContainer2.html");
    $admin_container2->setContent('elemento',"una nuova promozione");
    $admin_container2->setContent("HREF","adminPHP/adminPromozione.php?add=1");
    $res2 = $connessione->query("SELECT pr.* FROM Prodotto p JOIN Promozione pr ON p.id_promozione = pr.id")->fetch_all(MYSQLI_ASSOC); 

    $res = $connessione->query("SELECT * FROM Promozione")->fetch_all(MYSQLI_ASSOC); 
    foreach($res as $r){
        $item = new Template ("../skins/template/dtml/dtml_items/promozioneAdminItem.html");
        $idTmp = $r['id'];
        $item->setContent("NOME", $r['nome_promozione']);
        $item->setContent("DESCR", $r['descrizione']);
        $item->setContent("SCONTO",$r['sconto_percentuale']);
        $item->setContent("INIZIO",$r['data_inizio']);
        $item->setContent("FINE",$r['data_fine']);
        //caso in cui nessuna promozione è stata applicata
        if(count($res2)===0){
            $item->setContent("rimuovi_anchor",'<a style="pointer-events: none; opacity: 0.5;" class="btn btn-danger"> rimuovi </a>');
            $item->setContent("applica_anchor",'<a  href="adminPHP/adminPromozione.php?prom_id='.$idTmp.'" class="btn btn-primary ml-2"> Applica </a>');
        }
        //caso in cui c'è una promozione applicata
        else{
            // questa è la promozione applicata
            if($idTmp===$res2[0]['id']){
                $item->setContent("rimuovi_anchor",'<a  href="adminPHP/adminPromozione.php?prom_idDlt='.$idTmp.'" class="btn btn-danger"> rimuovi </a>');
                $item->setContent("applica_anchor",'<a style="pointer-events: none; opacity: 0.5;" class="btn btn-primary ml-2"> Applica </a>');
            }
            //queste sono promozioni non applicate
            else{
                $item->setContent("rimuovi_anchor",'<a style="pointer-events: none; opacity: 0.5;" class="btn btn-danger"> rimuovi </a>');
                $item->setContent("applica_anchor",'<a style="pointer-events: none; opacity: 0.5;" class="btn btn-primary ml-2"> Applica </a>');

            }

        }
        $admin_container2->setContent('item',$item->get());
    }
    echo ($admin_container2->get());
}
}
//display error 403
else{
    $temp = new Template("../skins/template/dtml/error403.html");
    $temp->close();
  
  }
    