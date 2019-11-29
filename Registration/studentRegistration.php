<?php
include("registrationFormStudent.php");


$submit = $_POST['submit'];

$login = strip_tags($_POST['login']);
$heslo = strip_tags($_POST['heslo']);
$meno = strip_tags($_POST['meno']);
$priezvisko = strip_tags($_POST['priezvisko']);
$email = strip_tags($_POST['email']);
$odbor = strip_tags($_POST['odbor']);
$kruzok = strip_tags($_POST['kruzok']);
$rocnik = strip_tags($_POST['rocnik']);
$kontrolaLoginu = $db->posliPoziadavku("SELECT * FROM Ucitel, Student WHERE Ucitel.login = '$login' OR Student.login='$login'");
$pocetVyskytov = mysqli_num_rows($kontrolaLoginu);

if($submit) {
    if ($pocetVyskytov == 0) {
        if ($login&$heslo&$meno&$priezvisko&$email&$odbor&$kruzok&$rocnik) {
                $heslo = md5($heslo);
                $test = $db->posliPoziadavku("INSERT INTO Student(id_odboru,login,heslo,meno,priezvisko,email,kruzok,rocnik) VALUES ('$odbor','$login','$heslo','$meno','$priezvisko','$email','$kruzok','$rocnik')");
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

