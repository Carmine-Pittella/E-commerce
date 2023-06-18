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
    $content = displayImg($idP,$connessione);
    $temp->setContent("lista-img",'<div class="col">'.$content.'</div>');
    $temp->setContent("id_p",$idP);
    $temp->close();
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

function displayImg($idProduct,$connessione){
    $strTOReturn="";
    $str1 = '<div class="product-thumbs">
                <div class="product-thumbs-track ps-slider owl-carousel owl-loaded owl-drag">
                    <div class="owl-stage-outer">
                        <div class="owl-stage">';
    $str2 = '           </div>
                    </div>
                    <div class="owl-nav">
                        <button type="button" role="presentation" class="owl-prev">
                        <i class="fa fa-angle-left"></i></button>
                        <button type="button" role="presentation" class="owl-next disabled">
                        <i class="fa fa-angle-right"></i></button>
                    </div>
                    <div class="owl-dots disabled"></div>
                </div>
            </div>';
    $rullino = popolaRullino($idProduct,$connessione);
    $strTOReturn = $strTOReturn.$str1.$rullino.$str2;
    return $strTOReturn;
    //return $rullino;

}
function popolaRullino($idProduct,$connessione){
    $strTOReturn="";
    $str1= '<div class="owl-item active" style="width: 103.333px; margin-right: 10px">
                <div class="pt" data-imgbigurl="';
    $str2= '"><img src="';
    $str3= '" alt="rullino" /></div></div>';
    $res = $connessione->query("SELECT url_immagine FROM Immagine_Prodotto WHERE id_prodotto = '$idProduct';")->fetch_all(MYSQLI_ASSOC);
    foreach ($res as $r) {
        $url = $r['url_immagine'];
        $url = "../". _IMG_PATH.$url;
        $strTOReturn = $strTOReturn.$str1.$url.$str2.$url.$str3;  
    }
    return $strTOReturn;

}


////////////// http://localhost/E-commerce/adminPHP/adminImmaginiProdotto.php?img=17&no=1

/*

                    <div class="product-thumbs">
                        <div class="product-thumbs-track ps-slider owl-carousel owl-loaded owl-drag">
                           <div class="owl-stage-outer">
                              <div class="owl-stage">
                                 <[foreach]> <[RULLINO_FOTO]> <[/foreach]>
                              </div>
                           </div>
                           <div class="owl-nav">
                              <button type="button" role="presentation" class="owl-prev">
                                 <i class="fa fa-angle-left"></i></button
                              ><button type="button" role="presentation" class="owl-next disabled">
                                 <i class="fa fa-angle-right"></i>
                              </button>
                           </div>
                           <div class="owl-dots disabled"></div>
                        </div>
                     </div>

    /********* popolamento rullino foto *********/
    /*
$res = $connessione->query("SELECT url_immagine FROM Immagine_Prodotto WHERE id_prodotto = {$product_id};")->fetch_all(MYSQLI_ASSOC);
$save_first = false;
foreach ($res as $r) {
    if (!$save_first) {
        $body->setContent("FOTO_PRINCIPALE_PRODOTTO", _IMG_PATH . $r['url_immagine']);
        $save_first = true;
    }
    $rullino_foto = new Template("skins/template/dtml/dtml_items/SequenzaFotoItem.html");
    $rullino_foto->setContent("URL_IMMAGINE", _IMG_PATH . $r['url_immagine']);
}
$body->setContent("RULLINO_FOTO", $rullino_foto->get());

<div class="owl-item active" style="width: 103.333px; margin-right: 10px">
   <div class="pt" data-imgbigurl="<[URL_IMMAGINE]>">
      <img src="<[URL_IMMAGINE]>" alt="rullino" />
   </div>
</div>



*/