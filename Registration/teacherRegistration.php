<?php
include("registrationFormTeacher.php");


$submit = $_POST['submit'];

$login = strip_tags($_POST['login']);
$heslo = strip_tags($_POST['heslo']);
$meno = strip_tags($_POST['meno']);
$priezvisko = strip_tags($_POST['priezvisko']);
$email = strip_tags($_POST['email']);
$katedra = strip_tags($_POST['katedra']);
$kontrolaLoginu = $db->posliPoziadavku("SELECT * FROM Ucitel, Student WHERE Ucitel.login = '$login' OR Student.login='$login'");
$pocetVyskytov = mysqli_num_rows($kontrolaLoginu);

if($submit) {
    if ($pocetVyskytov == 0) {
        if ($login&$heslo&$meno&$priezvisko&$email&$katedra) {
            $heslo = md5($heslo);
            $test = $db->posliPoziadavku("INSERT INTO Ucitel(id_katedry,login,heslo,meno,priezvisko,email,prava) VALUES ('$katedra','$login','$heslo','$meno','$priezvisko','$email','U')");
            ?>
            <script>
                window.location = "../Login/loginForm.php";
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

