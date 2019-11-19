<?php
// Include the database config file
include ("../database.php");
$db = new database();
$db->pripoj();
$xxx = $_POST["country_id"];



if(!empty($_POST["country_id"])){
    // Fetch state data based on the specific country
    $query = "SELECT * FROM Fakulta WHERE id_skoly = ".$_POST['country_id']."";
    $result = $db->posliPoziadavku($query);
    // Generate HTML of state options list
    if($result->num_rows > 0){
        echo '<option value="">Vyber fakultu</option>';
        while($row = $result->fetch_assoc()){
            echo '<option value="'.$row['id_fakulty'].'">'.$row['nazov'].'</option>';
        }
    }else{
        echo '<option value="">State not available</option>';
    }
}elseif(!empty($_POST["state_id"])){
    // Fetch city data based on the specific state
    $query = "SELECT * FROM Odbor WHERE id_fakulta = ".$_POST['state_id']."";
    $result = $db->posliPoziadavku($query);
    // Generate HTML of city options list
    if($result->num_rows > 0){
        echo '<option value="">Vyber odbor</option>';
        while($row = $result->fetch_assoc()){
            echo '<option value="'.$row['id_odboru'].'">'.$row['nazov_odboru'].'</option>';
        }
    }else{
        echo '<option value="">City not available</option>';
    }
}
?><?php
