<?php
// Include the database config file
include("../database.php");
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
            echo '<option value="'.$row['id_fakulty'].'">'.$row['nazov_fakulty'].'</option>';
        }
    }else{
        echo '<option value="">Fakulty nie su dostupné</option>';
    }
}elseif(!empty($_POST["state_id"])){
    // Fetch city data based on the specific state
    $query = "SELECT * FROM Odbor JOIN Katedra USING (id_katedry)WHERE id_fakulty = ".$_POST['state_id']."";
    $result = $db->posliPoziadavku($query);
    // Generate HTML of city options list
    if($result->num_rows > 0){
        echo '<option value="">Vyber odbor</option>';
        while($row = $result->fetch_assoc()){
            echo '<option value="'.$row['id_odboru'].'" id="odbor">'.$row['nazov_odboru'].'</option>';
        }
    }else{
        echo '<option value="">Odbory nie su dostupné</option>';
    }
} elseif(!empty($_POST["faculty_id"])){
    // Fetch city data based on the specific state
    $query = "SELECT * FROM Katedra WHERE id_fakulty = ".$_POST['faculty_id']."";
    $result = $db->posliPoziadavku($query);
    // Generate HTML of city options list
    if($result->num_rows > 0){
        echo '<option value="">Vyber katedru</option>';
        while($row = $result->fetch_assoc()){
            echo '<option value="'.$row['id_katedry'].'" id="katedra">'.$row['nazov_katedry'].'</option>';
        }
    }else{
        echo '<option value="">Katedry nie su dostupné</option>';
    }
}
if(!empty($_POST["id_predmetu"])) {
    // Fetch state data based on the specific country
    $query = "SELECT * FROM Tema WHERE id_predmetu = " . $_POST['id_predmetu'] . "";
    $result = $db->posliPoziadavku($query);
// Generate HTML of state options list
    if ($result->num_rows > 0) {
        echo '<option value="">Vyber tému</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['id_temy'] . '">' . $row['nazov_temy'] . '</option>';
        }
    } else {
        echo '<option value="">Témy nie su dostupné</option>';
    }
}
?>
