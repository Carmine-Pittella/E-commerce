<?php
require "../include/template2.inc.php";
require "../include/dbms.inc.php";

require_once "../include/php-utils/global.php";
// variabile _IMG_PATH  skins/template/img/        products/nomeimg.png

//img è l'id dell'ultimo elemento inserito, la chiamata viene da adminAddProdotto
if(isset($_GET['img'])){
    $str = $_GET['img'];
    $str = "eskere dentro adminImgPr  ". $str;
    $str = "<script>console.log('".$str."')</script>";
    echo $str;
}






/*
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

 $str = '<div class="col">le immaggini verranno inserite qui</div>';
    $template->setContent("lista-img",$str);


<form  action="adminAddProdotto.php" method="post" enctype="multipart/form-data">
        <div style="height: 200px; position: relative; top: 30px;" id="imageContainer" class="container">
          <h4 style="position: relative; bottom: 20px;">Inserisci immagini</h4>
          <div class="row">
            <div class="col">
              <input type="file" name="formImage">
            </div>
            <[lista-img]>
          </div>
          <button type="submit" class="btn btn-primary">carica immagine</button>
        </div>
      </form>
*/