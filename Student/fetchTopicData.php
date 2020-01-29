<?php
include "../database.php";
$db = new database();
$db->pripoj();
//id vybranej temy
$id_temy = $_POST['id_temy'];
$result = $db->posliPoziadavku( "SELECT * FROM Tema JOIN Predmet USING (id_predmetu) where id_temy ='$id_temy' ");
$row = mysqli_fetch_object($result);
echo json_encode($row);
exit();