<?php
require "../include/template2.inc.php";
require "../include/dbms.inc.php";
global $connessione;


// display per la risposta
if(isset($_GET['r'])){

}

// display lista richieste aperte 
if( (!isset($_GET['r'])) ){
$admin_container3 = new Template("../skins/template/adminContainer3.html");
$res = $connessione->query("SELECT * FROM Messaggio_Assistenza WHERE risposta IS NULL")->fetch_all(MYSQLI_ASSOC); 
        foreach($res as $r){
            $item = new Template("../skins/template/dtml/dtml_items/assistenzaAdminItem.html");
            $idUtente = $r['id_utente'];
            $res2 = $connessione->query("SELECT * FROM Utente WHERE id = '$idUtente'")->fetch_all(MYSQLI_ASSOC); 
            $item->setContent("NOME_UTENTE",$res2[0]['nome']);
            $item->setContent("RICHIESTA",$r['richiesta']);
            $item->setContent("ID",$idUtente);
            $admin_container3->setContent("item",$item->get());
        }
    $admin_container3->close();
}

/*
adminPHP/adminAssistenza.php?i=<[ID]>$r=<[RICHIESTA]>

CREATE TABLE IF NOT EXISTS Messaggio_Assistenza (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_utente INT NOT NULL,
    richiesta TEXT(500),
    risposta TEXT(500) DEFAULT NULL,
    FOREIGN KEY (id_utente) REFERENCES Utente(id)
);
*/