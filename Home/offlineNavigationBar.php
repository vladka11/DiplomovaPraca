<?php
if(session_id() == '') {
    session_start();
}
include '../database.php';
include 'modalTopic.php';
include 'modalSubject.php';

$db = new database();
$db->pripoj();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Offline mode</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
          integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="navBarDesign.css?version8">
    <link href="modalDesign.css?version5" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="contentDesign.css?version12">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
            integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
            crossorigin="anonymous"></script>
</head>
<body>

<div class="wrapper">
    <!-- Sidebar Holder -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <a><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION["login"] ?></a>
        </div>

        <ul class="list-unstyled components">
            <?php

            $logged_id = $_SESSION["userid"];
            $udajeZDb = $db->posliPoziadavku("SELECT nazov_predmetu, id_predmetu FROM Predmet JOIN Vyucuje USING (id_predmetu) WHERE id_ucitela = '$logged_id' ORDER BY nazov_predmetu");
            $numrows = mysqli_num_rows($udajeZDb);
            if ($numrows != 0) {
                while ($row = mysqli_fetch_assoc($udajeZDb)) {
                    $predmet_id = $row['id_predmetu'];
                    ?>
                    <li>
                        <!-- Výpis predmetov -->
                        <a href="#<?php echo $predmet_id ?>" data-toggle="collapse" aria-expanded="false"
                           class="dropdown-toggle"><?php echo $row['nazov_predmetu'] ?></a>
                        <?php
                        $temyPredmetu = $db->posliPoziadavku("SELECT nazov_temy, id_temy FROM Tema WHERE id_predmetu= '$predmet_id' ");
                        $numrows2 = mysqli_num_rows($temyPredmetu);
                       // if ($numrows2 != 0) {
                            ?>
                            <ul class="collapse list-unstyled" id="<?php echo $predmet_id ?>">
                                <?php
                                while ($row2 = mysqli_fetch_assoc($temyPredmetu)) {
                                    ?>
                                    <li>
                                        <!-- Výpis tém k predmetom -->
                                        <a class="temy"
                                           id="<?php echo $row2['id_temy'] . 'x' . $predmet_id ?>"><?php echo $row2['nazov_temy'] ?></a>
                                    </li>
                                    <?php
                                }
                                ?>

                                <li  onclick="pridajTemu(id)" id="<?php echo $predmet_id ?>" >
                                    <a><span class="glyphicon glyphicon-plus-sign"></span> Pridaj novú tému</a>
                                </li>
                            </ul>
                            <?php
                        }
                        ?>
                    </li>
                    <?php
               // }
            } ?>

            <li class="nav-item">
                <a class="text" id="addSubject" onclick="document.getElementById('modalSubject').style.display='block';"> <span class="glyphicon glyphicon-plus-sign"></span>  Pridaj predmet</a>
            </li>
            <hr>

            <li class="nav-item">
                <a class="text" id="allQuestion" onclick="showAllQuestions()">Všetky otázky</a>
            </li>
            <li class="nav-item">
                <a class="text" id="newQuestion" onclick="addNewQuestion()"> <span class="glyphicon glyphicon-plus-sign"></span>  Pridaj otázku</a>
            </li>
            <hr>

            <li class="nav-item">
                <a class="text" id="students" onclick="showAllStudents()"> Študenti </a>
            </li>
            <hr>
            <li class="nav-item">
                <a class="logout" id="logout"> Odhlásiť sa</a>
            </li>

            <li class="nav-item align-items-end">
                <button type="submit" onclick="onlineRezim()" class="btn btn-default">Online režim </button>
            </li>
        </ul>
    </nav>


    <script type="text/javascript">
        function addNewQuestion() {
            window.location = "./newQuestionForm.php";
        }

        function showAllQuestions() {
            window.location = "./allQuestionTable.php";
        }

        function showAllStudents() {
            window.location = "allStudentsTable.php";
        }

        function pridajTemu(id){
            document.getElementById('myModal').style.display='block';
            document.getElementById('predmetSelect').value=id;
        }
        function onlineRezim(){
            window.location = "../Home/onlineContent.php";
        }

        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
                $(this).toggleClass('active');
            });
        });

        $(document).ready(function () {
            $(".temy").click(function (e) {
                var id = $(this).attr('id');
                document.cookie = "predmetTema= " + id;
                window.location.replace("http://localhost:8080/DiplomovaPraca/Home/offlineContent.php");
            });
        });

        $(document).ready(function () {
            $(".logout").click(function (e) {
                window.location = "../Login/logout.php";
            });
        });

    </script>
</body>
</html>
