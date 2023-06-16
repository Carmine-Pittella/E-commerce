<?php
require "../include/template2.inc.php";
require "../include/dbms.inc.php";

require_once "../include/php-utils/global.php";
// variabile _IMG_PATH  skins/template/img/        products/nomeimg.png

global $connessione;
// <[select_categoria]> 
// <[select_marca]> 

//display della form per l'aggiunta di un prodotto
if(isset($_GET['add'])){
    $template = new Template("../skins/template/adminAddProdotto.html");

    //popola  la categoria
    $res = $connessione->query("SELECT * FROM Categoria")->fetch_all(MYSQLI_ASSOC);
    $tot = "";
    foreach($res as $r){
        $str = $r['nome_categoria'];
        $str = '<option value="'.$str.'">'.$str."</option>";
        $tot = $tot.$str;
    }
    $template->setContent("select_categoria",$tot);
    //popola le marche
    $res = $connessione->query("SELECT * FROM Marca")->fetch_all(MYSQLI_ASSOC);
    $tot = "";
    foreach($res as $r){
        $str = $r['nome_marca'];
        $str = '<option value="'.$str.'">'.$str."</option>";
        $tot = $tot.$str;
    }
    $template->setContent("select_marca",$tot);
    //img 
    $str = '<div class="col">le immaggini verranno inserite qui</div>';
    $template->setContent("lista-img",$str);

    $template->close();

}

if(isset($_FILES['formImage'])){
    $file= $_FILES['formImage'];
    $fileName = $file['name'];
    $tmpFilePath = $file['tmp_name'];

    $uploadDir = 'C:\Users\fabri\Desktop\xampp\htdocs\E-commerce\skins\template\img\products\\'; 
    $uploadPath = $uploadDir . $fileName;
    if (move_uploaded_file($tmpFilePath, $uploadPath)) {
        echo '<script>console.log("successo")</script>';
    } else {
        echo '<script>console.log("successo")</script>';
    }
}



 /*
    if (isset($_FILES['image'])) {
   $file = $_FILES['image'];

   // Ottieni il nome e il percorso temporaneo dell'immagine
   $fileName = $file['name'];
   $tmpFilePath = $file['tmp_name'];

   // Crea una destinazione finale per l'immagine
   $uploadDir = 'upload/'; // Directory di destinazione (assicurati di averla creata in precedenza)
   $uploadPath = $uploadDir . $fileName;

   // Sposta l'immagine dalla posizione temporanea alla destinazione finale
   if (move_uploaded_file($tmpFilePath, $uploadPath)) {
      echo 'Immagine caricata con successo.';
   } else {
      echo 'Si è verificato un errore durante il caricamento dell\'immagine.';
   }
}
    */
