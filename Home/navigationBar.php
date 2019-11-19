<?php
session_start();
include("../database.php");
$db = new database();
$db->pripoj();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Online mode</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
          integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="navBarDesign.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js"
            integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ"
            crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js"
            integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY"
            crossorigin="anonymous"></script>
    <script src="https://www.w3schools.com/js/myScript1.js"></script>


    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
            integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
            crossorigin="anonymous"></script>
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
            $logged_id = $_SESSION["id_login"];
            $udajeZDb = $db->posliPoziadavku("SELECT nazov_predmetu, id_predmetu FROM Predmet WHERE id_ucitela = '$logged_id' ORDER BY nazov_predmetu");
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
                        if ($numrows2 != 0) {
                            ?>
                            <ul class="collapse list-unstyled" id="<?php echo $predmet_id ?>">
                                <?php
                                while ($row2 = mysqli_fetch_assoc($temyPredmetu)) {
                                    ?>
                                    <li>
                                        <!-- Výpis tém k predmetom -->
                                        <a class="lala"
                                           id="<?php echo $row2['id_temy'] . 'x' . $predmet_id ?>"><?php echo $row2['nazov_temy'] ?></a>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                            <?php
                        }
                        ?>
                    </li>
                    <?php
                }
            } ?>
        </ul>
    </nav>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
                $(this).toggleClass('active');
            });
        });

        $(document).ready(function () {
            $(".lala").click(function (e) {
                var id = $(this).attr('id');
                document.cookie = "predmetTema= " + id;
                window.location.replace("http://localhost:8080/DiplomovaPraca/Home/content.php");
            });
        });
    </script>
</body>
</html>
