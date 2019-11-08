<?php
include ("../database.php");
include ("registrationForm.php");
$db = new database();
$db->pripoj();

$submit = $_POST['submit'];

$login = strip_tags($_POST['login']);
$heslo = strip_tags($_POST['heslo']);
$meno = strip_tags($_POST['meno']);
$priezvisko = strip_tags($_POST['priezvisko']);
$email = strip_tags($_POST['email']);
$skola = strip_tags($_POST['skola']);
$fakulta = strip_tags($_POST['fakulta']);
$odbor = strip_tags($_POST['odbor']);
$kruzok = strip_tags($_POST['kruzok']);
$rocnik = strip_tags($_POST['rocnik']);

$kontrolaLoginu = $db->posliPoziadavku("SELECT login FROM Student WHERE login='$login'");
$pocetVyskytov = mysqli_num_rows($kontrolaLoginu);

if($submit) {
    if ($pocetVyskytov == 0) {
        if ($login&$heslo&$meno&$priezvisko&$email&$skola&$fakulta&$odbor&$kruzok&$rocnik) {
                $heslo = md5($heslo);
                $test = $db->posliPoziadavku("INSERT INTO Student(login,heslo,meno,priezvisko,email,kruzok,rocnik) VALUES ('$login','$heslo','$meno','$priezvisko','$email','$kruzok','$rocnik')");
                ?>
                <script>
                    window.location = "loginForm.php";
                </script>

                <?php
                exit();

        } else {
            ?>
            <html>
            <body>
            <script> var sprava = document.getElementById("error-message");
                sprava.innerHTML = "Zadaj všetky údaje!";
            </script>
            </body>
            </html>

            <?php
        }
    } else {
        ?>
        <html>
        <body>
        <script> var sprava = document.getElementById("error-message");
            sprava.innerHTML = "Uživateľské meno už existuje, zvoľ iné!";
        </script>
        </body>
        </html>

        <?php
    }

}

