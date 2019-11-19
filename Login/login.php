<?php
session_start();
include ("../database.php");
include ("loginForm.php");
    $db = new database();
    $db->pripoj();
    $prihlasovacieMeno = $_POST["email"];
    $heslo = $_POST["pwd"];


    $udajeZDb = $db->posliPoziadavku("SELECT * FROM Student WHERE login = '$prihlasovacieMeno'");
    $numrows = mysqli_num_rows($udajeZDb);
    if ($numrows!= 0){
        while($row = mysqli_fetch_assoc($udajeZDb)) {
            $dbusername = $row['login'];
            $dbpassword = $row['heslo'];
            $id_studenta = $row['id_studenta'];
        }

        if ($prihlasovacieMeno == $dbusername && $dbpassword == md5($heslo)){
            $_SESSION['logged_id']= $id_studenta;
            $_SESSION['login']= $dbusername;
            ?>
            <script>window.location = "../Home/content.php";</script>
            <?php
        } else{
            ?>
            <html><body><script> var chyba = document.getElementById("error-message");
                chyba.innerHTML = "Zadané heslo je nesprávne";
            </script></body></html>

            <?php

        }

    } else{
        ?>
        <html><body><script> var chyba = document.getElementById("error-message");
            chyba.innerHTML = "Použivateľské meno neexistuje!";
        </script></body></html>

        <?php

}
?>