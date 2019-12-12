<?php
$newTopic = $_POST["topic"];
if($newTopic!=""){
    include("../database.php");
    $db = new database();
    $db->pripoj();
    $db->posliPoziadavku("INSERT INTO Tema(id_predmetu,nazov_temy,cislo_temy) VALUES ('5','$newTopic','7')");
    ?>
    <script>
        window.location = "offlineContent.php";
    </script>
    <?php
}else{
    include 'offlineContent.php';
?>
 <script>
     document.getElementById('emptyModal').innerHTML="Téma nesmie byť prázdna.";
     document.getElementById('myModal').style.display='block';
 </script>
<?php
}
?>
