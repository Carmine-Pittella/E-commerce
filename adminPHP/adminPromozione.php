<?php
require "../include/template2.inc.php";
require "../include/dbms.inc.php";
global $connessione;



//echo "<div>ADMINPROMOZIONE</div>";


// display lista marche

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


   