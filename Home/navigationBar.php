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
    <link rel="stylesheet" href="navBarDesign.css?version4">
    <link rel="stylesheet" href="contentDesign.css?version2">
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
            $logged_id = $_SESSION["logged_id"];
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
                        if ($numrows2 != 0) {
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
                            </ul>
                            <?php
                        }
                        ?>
                    </li>
                    <?php
                }
            } ?>

            <li class="nav-item">
                <a class="logout" id="logout"> Odhlásiť sa</a>
            </li>

                <li class="nav-item align-items-end">
                    <button type="submit" class="btn btn-default">Offline režim </button>
                </li>
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
            $(".temy").click(function (e) {
                var id = $(this).attr('id');
                document.cookie = "predmetTema= " + id;
                window.location.replace("http://localhost:8080/DiplomovaPraca/Home/content.php");
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
