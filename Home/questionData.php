<?php
include "../database.php";
$db = new database();
$db->pripoj();
//id vybranej temy
if(isset( $_POST['id_temy'])){
    $id_temy = $_POST['id_temy'];
    $result = $db->posliPoziadavku( "SELECT * FROM Otazka where id_temy ='$id_temy' ");
    $data = array();

    while ($row = mysqli_fetch_object($result))
    {
        array_push($data, $row);
    }

    echo json_encode($data);
    exit();
}
