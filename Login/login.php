
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

            switch ($person) {
                case 'student': $id_user = $row['id_studenta'];break;
                case 'admin':
                case 'ucitel': $id_user = $row['id_ucitela']; break;
            }
        }

        if ($prihlasovacieMeno == $dbusername && $dbpassword == md5($heslo)){
            $_SESSION['userid']= $id_user;
            $_SESSION['login']= $dbusername;
            switch ($person) {
                case 'ucitel':
                    ?>
                    <script>window.location = "../Transition/transitionPage.php";</script>
                <?php
                    break;
                case 'student':
                    ?>
                    <script>window.location = "../Student/homepage.php";</script>
                    <?php
                    break;
                case 'admin':

                    break;
            }

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