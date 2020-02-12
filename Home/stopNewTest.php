<?php
include("../database.php");
$db = new database();
$db->pripoj();

if(!empty($_POST["test_id"])){
    $testID = $_POST["test_id"];
    $question_id=$_POST["clicked_question_id"];
    $db->posliPoziadavku("UPDATE Otazka_na_teste SET spustena= '0' WHERE id_testu = '$testID' AND id_otazky = '$question_id'");

}