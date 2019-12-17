<?php

if(session_id() == '') {
    session_start();
}
$logged_id = $_SESSION["logged_id"];
$subjectName = $_POST["subject"];
$year = $_POST["year"];

if($subjectName!="" && $year!=""){
    include("../database.php");
    $db = new database();
    $db->pripoj();
    $udajeUcitela= $db->posliPoziadavku("SELECT * FROM Ucitel WHERE id_ucitela ='$logged_id'");
    $numrows = mysqli_num_rows($udajeUcitela);
    if ($numrows!= 0) {
        while ($row = mysqli_fetch_assoc($udajeUcitela)) {
            $id_katedry = $row['id_katedry'];
            $db->posliPoziadavku("INSERT INTO Predmet(id_katedry,nazov_predmetu,rocnik) VALUES ('$id_katedry','$subjectName','$year')");
        }

        $lastSubjectId = $db->getLastId();
        // TODO  zameniť ročník za čosi iné
        $db->posliPoziadavku("INSERT INTO Vyucuje(id_ucitela,id_predmetu,rok_vyucby) VALUES ('$logged_id','$lastSubjectId','2019')");
        $db->odpoj();
        ?>
        <script>
            window.location = "offlineContent.php";
        </script>
        <?php
    }
}else{
    include 'offlineContent.php';
    ?>
    <script>
        document.getElementById('emptySubjectModal').innerHTML="Zadané polia nesmú ostať prázdne.";
        document.getElementById('modalSubject').style.display='block';
    </script>
    <?php
}
?>