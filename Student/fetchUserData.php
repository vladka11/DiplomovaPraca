<?php
include '../database.php';
$db = new database();
$db->pripoj();

session_start();
$user_id = $_SESSION["userid"];

if(isset($_POST["user_data"]))
{
    $logged_user_profile = $db->posliPoziadavku("SELECT * FROM Student JOIN Odbor USING (id_odboru) WHERE id_studenta ='$user_id' ");
    $row = $logged_user_profile->fetch_assoc();
    echo json_encode($row);
}

