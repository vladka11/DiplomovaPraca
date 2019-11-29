
<?php
session_start();
include ("../database.php");
include ("loginForm.php");
    $db = new database();
    $db->pripoj();
    $prihlasovacieMeno = $_POST["email"];
    $heslo = $_POST["pwd"];
    $person = ($_POST["optradio"]);
    switch ($person) {
        case 'student':
            $udajeZDb = $db->posliPoziadavku("SELECT * FROM Student WHERE login = '$prihlasovacieMeno'");
            break;
        case 'ucitel':
            $udajeZDb = $db->posliPoziadavku("SELECT * FROM Ucitel WHERE login = '$prihlasovacieMeno' AND prava ='U'");
            break;
        case 'admin':
            $udajeZDb = $db->posliPoziadavku("SELECT * FROM Ucitel WHERE login = '$prihlasovacieMeno' AND prava = 'A'");
            break;
    }

    $numrows = mysqli_num_rows($udajeZDb);
    if ($numrows!= 0){
        while($row = mysqli_fetch_assoc($udajeZDb)) {
            $dbusername = $row['login'];
            $dbpassword = $row['heslo'];
            $id_ucitela = $row['id_ucitela'];
        }

        if ($prihlasovacieMeno == $dbusername && $dbpassword == md5($heslo)){
            $_SESSION['logged_id']= $id_ucitela;
            $_SESSION['login']= $dbusername;
            ?>
            <script>window.location = "../Transition/transitionPage.php";</script>
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
            chyba.innerHTML = "Použivateľské meno neexistuje! Skontroluj správne zvolené prostredie :)";
        </script></body></html>

        <?php

}
?>