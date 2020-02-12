<?php
include '../database.php';
if(session_id() == '') {
    session_start();
}
$db = new database();
$db->pripoj();

//Získanie údajov z formulára
$logged_id =$_SESSION["userid"];
$topic_id = $_POST["topic"];
$question = $_POST["question"];
$answers = json_decode(stripslashes($_POST['answers']));
$weight = $_POST["weight"];
$my_array_data = json_decode(($_POST['answers']), TRUE);

//Vloženie otázky do databázy
    $db->posliPoziadavku("INSERT INTO Otazka(id_temy,text_otazky,typ_otazky,vaha,max_body) VALUES ('$topic_id','$question','A','$weight','0')");
    $id_otazky = $db->getLastId();

    $sucet_bodov=0;
    //Vloženie možností s daným počtom bodov do db
    //TODO ošetriť že aspon jedna odpoved musí byť správna
    for($i=0; $i < sizeof($my_array_data); $i++){
        if(!empty($my_array_data[$i])){
           $x= 1 + $i;
           $body =($my_array_data[$x] > 0) ? $my_array_data[$x] : '0';
           $sucet_bodov+=$body;
           $spravnost = ($body > 0) ? 'TRUE' : 'FALSE';
           $db->posliPoziadavku("INSERT INTO Odpoved(id_otazky,text_odpovede,spravnost,body) VALUES ('$id_otazky','$my_array_data[$i]','$spravnost','$body')");
           $i++;
        }
    }

    //Pridanie max počtu bodov za otazku
    $max_body= $sucet_bodov*$weight;
    $db->posliPoziadavku("UPDATE Otazka SET max_body='$max_body' WHERE id_otazky = '$id_otazky'");
