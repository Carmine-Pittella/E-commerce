<?php
require "../include/template2.inc.php";
require "../include/dbms.inc.php";

require_once "../include/php-utils/global.php";
// variabile _IMG_PATH  skins/template/img/        products/nomeimg.png
global $connessione;

//img è l'id dell'ultimo elemento inserito, la chiamata viene da adminAddProdotto
if(isset($_GET['img'])){
    $idP = $_GET['img'];
    $temp = new Template("../skins/template/adminImgProdotto.html");
    
    //caso in cui non ci sono immagini
   if(isset($_GET['no'])){
    $temp->setContent("lista-img","<div class='col'> non ci sono immagini </div>");
    $temp->setContent("id_p",$idP);
    $temp->close();
   }

   //caso in cui ci sono immagini
   else{
    echo '<script>console.log("dio porco")</script>';

   }
}
if(isset($_FILES['formImage'])){

    
    
    //(1, 'products/M-element-Tshirt-front-blu.jpg'),
    $file= $_FILES['formImage'];
    $fileName = $file['name'];
    $tmpFilePath = $file['tmp_name'];

    
    $idP = $_POST['formId'];
    $pathDB = "products/".$fileName;
    $connessione->query("INSERT INTO Immagine_Prodotto (id_prodotto, url_immagine)
    VALUES ( $idP, '$pathDB')");
    
    
    $uploadDir = 'C:\Users\fabri\Desktop\xampp\htdocs\E-commerce\skins\template\img\products\\'; 
    $uploadPath = $uploadDir . $fileName;
    move_uploaded_file($tmpFilePath, $uploadPath);
    header("location:http://localhost/E-commerce/adminPHP/adminImmaginiProdotto.php?img=$idP");
    exit();

    
}


////////////// http://localhost/E-commerce/adminPHP/adminImmaginiProdotto.php?img=17&no=1

/*

 if (move_uploaded_file($tmpFilePath, $uploadPath)) {
        echo '<script>console.log("successo")</script>';
    } else {
        echo '<script>console.log("fallimento")</script>';
    }
*/