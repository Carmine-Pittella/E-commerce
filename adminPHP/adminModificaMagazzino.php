<?php


require "../include/template2.inc.php";
require "../include/dbms.inc.php";
global $connessione;


//chiamata su modifica
if(isset($_GET['mod'])){
    $modMagazzino = new Template("../skins/template/adminModificaMagazzino.html");
    $idItem = $_GET['mod'];
    $res = $connessione->query("SELECT * FROM Categoria")->fetch_all(MYSQLI_ASSOC);
    
    $res2 = $connessione->query(" SELECT Prodotto.id AS id_prodotto,Prodotto.nome_prodotto,Prodotto.descrizione,Prodotto.prezzo,Prodotto.genere,Categoria.id AS id_categoria,Categoria.nome_categoria,Marca.id AS id_marca,Marca.nome_marca,Magazzino.quantita,Magazzino.taglia
    FROM Prodotto JOIN Categoria ON Prodotto.id_categoria = Categoria.id JOIN Marca ON Prodotto.id_marca = Marca.id JOIN Magazzino ON Prodotto.id = Magazzino.id_prodotto;")->fetch_all(MYSQLI_ASSOC);
    $resFiltered = array();
    foreach ($res2 as $row) {
        if ($row['id_prodotto'] == $idItem) {
            $resFiltered[] = $row;
        }
    }

    //popola e seleziona la categoria
    $tot = "";
    foreach($res as $r){
        $str = $r['nome_categoria'];
        if($r['nome_categoria']===$resFiltered[0]['nome_categoria']){
            $str = '<option value="'.$str.'" selected>'.$str."</option>";
            $tot = $tot.$str;
        }else{
            $str = '<option value="'.$str.'">'.$str."</option>";
            $tot = $tot.$str;
        } 
    }
    $modMagazzino->setContent("select_categoria",$tot);
    $res = $connessione->query("SELECT * FROM Marca")->fetch_all(MYSQLI_ASSOC);

    //popola e seleziona la marca
    $tot = "";
    foreach($res as $r){
        $str = $r['nome_marca'];
        if($r['nome_marca']===$resFiltered[0]['nome_marca']){
            $str = '<option value="'.$str.'" selected>'.$str."</option>";
            $tot = $tot.$str;
        }else{
            $str = '<option value="'.$str.'">'.$str."</option>";
            $tot = $tot.$str;
        }
    }
    //popola e seleziona il genere
    $modMagazzino->setContent("select_genere",selectGenere($resFiltered[0]['genere']));
    //popola le quantità per ogni taglia



    $modMagazzino->setContent("select_marca",$tot);


    $modMagazzino->close();
}
//chiamata su delete 
else{

}



function selectGenere($str1) {
    $toret = '';
    
    switch ($str1) {
        case 'uomo':
            $toret = '
                <option value="uomo" selected>uomo</option>
                <option value="donna">donna</option>
                <option value="bambino">bambino</option>
            ';
            break;
        case 'donna':
            $toret = '
                <option value="uomo">uomo</option>
                <option value="donna" selected>donna</option>
                <option value="bambino">bambino</option>
            ';
            break;
        case 'bambino':
            $toret = '
                <option value="uomo">uomo</option>
                <option value="donna">donna</option>
                <option value="bambino" selected>bambino</option>
            ';
            break;
    }

    return $toret;
}