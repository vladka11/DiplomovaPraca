<?php
session_start();
$logged_id = $_SESSION["logged_id"];

include("../database.php");
$db = new database();
$db->pripoj();

$today=date("Y-m-d");
if(!empty($_POST["createTest"])){
    $db->posliPoziadavku("INSERT INTO Test(id_ucitela, datum_testu) VALUES('$logged_id','$today')");
    $test_id=$db->getLastId();
    echo $test_id;
}

if(!empty($_POST["clicked_question_id"])){
    $question_id=$_POST["clicked_question_id"];
    $test_id=$_POST["test_id"];
    $db->posliPoziadavku("INSERT INTO Otazka_na_teste(id_testu, id_otazky) VALUES('$test_id','$question_id')");
}