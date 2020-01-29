<?php
include "./header.php";
include '../database.php';
$db = new database();
$db->pripoj();

?>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
        integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
        crossorigin="anonymous"></script>
<div id="subjectList">
    <h4>Zoznam všetkých predmetov: </h4>
 <ul class="list-unstyled components">
            <?php
            $logged_id = $_SESSION["userid"];
            $udajeZDb = $db->posliPoziadavku("SELECT nazov_predmetu, id_predmetu FROM Predmet JOIN Studuje USING (id_predmetu) JOIN Student USING (id_studenta) WHERE id_studenta = '$logged_id' ORDER BY nazov_predmetu");
            $numrows = mysqli_num_rows($udajeZDb);
            if ($numrows != 0) {
                while ($row = mysqli_fetch_assoc($udajeZDb)) {
                    $predmet_id = $row['id_predmetu'];
                    ?>
                    <li>
                        <!-- Výpis predmetov -->
                        <a href="#<?php echo $predmet_id ?>" data-toggle="collapse" aria-expanded="false" id="subjectName"
                           class="dropdown-toggle">➤ <?php echo $row['nazov_predmetu'] ?></a>
                        <?php
                        $temyPredmetu = $db->posliPoziadavku("SELECT nazov_temy, id_temy FROM Tema WHERE id_predmetu= '$predmet_id' ");
                        $numrows2 = mysqli_num_rows($temyPredmetu);
                        if ($numrows2 != 0) {
                            ?>
                            <ul class="collapse list-unstyled" id="<?php echo $predmet_id ?>">
                                <?php
                                while ($row2 = mysqli_fetch_assoc($temyPredmetu)) {
                                    ?>
                                    <li style="list-style-type: decimal; margin-left: 20px; color:black;">
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
 </ul>
</div>
<script>
    $(document).ready(function () {
        $(".temy").click(function (e) {
            var id = $(this).attr('id');
            document.cookie = "predmetTema= " + id;
            window.location.replace("http://localhost:8080/DiplomovaPraca/Student/allQuestionList.php");
        });
    });
</script>
