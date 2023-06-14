<?php


require "../include/template2.inc.php";
require "../include/dbms.inc.php";
global $connessione;


//chiamata su modifica
if(isset($_GET['mod'])){
    $modMagazzino = new Template("../skins/template/adminModificaMagazzino.html");
    $idItem = $_GET['mod'];
    $res = $connessione->query("SELECT * FROM Categoria")->fetch_all(MYSQLI_ASSOC);
    $tot = "";
    foreach($res as $r){
        $str = $r['nome_categoria'];
        $str = '<option value="'.$str.'">'.$str."</option>";
        $tot = $tot.$str;
    }
    $modMagazzino->setContent("select_categoria",$tot);
    $res = $connessione->query("SELECT * FROM Marca")->fetch_all(MYSQLI_ASSOC);
    $tot = "";
    foreach($res as $r){
        $str = $r['nome_marca'];
        $str = '<option value="'.$str.'">'.$str."</option>";
        $tot = $tot.$str;
    }
    $modMagazzino->setContent("select_marca",$tot);
    $modMagazzino->close();
}
//chiamata su delete 
else{

}

