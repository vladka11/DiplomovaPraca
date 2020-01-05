<?php

if (isset($_COOKIE['id_otazky'])) {
    $id_otazky = $_COOKIE["id_otazky"];
}

$clicked_question = $db->posliPoziadavku("SELECT * FROM Otazka JOIN Tema USING (id_temy) JOIN Predmet USING(id_predmetu) JOIN Vyucuje USING (id_predmetu) 
                                                    WHERE id_otazky ='$id_otazky'");
$numrows = mysqli_num_rows($clicked_question);
if ($numrows != 0) {
    while ($row = mysqli_fetch_assoc($clicked_question)) {
        ?>

        <?php
    }
    echo "</table>";
}
?>

<div id="dataModal" class="modal fade">
  <span onclick="document.getElementById('id01').style.display='none'"
        class="close" title="Close Modal">&times;</span>

    <!-- Modal Content -->
    <form class="modal-content animate" action="/action_page.php">
        <div class="container">
            <div class="form-group">
                <div style="width: 45%">
                    <legend for="newQuestionSubject">Predmet <?php echo  $_COOKIE["id_otazky"] ?> </legend>
                    <div class="form-group">
                        <select class="form-control" id="newQuestionSubject" name="newQuestionSubject" style="height: 30px">
                            <option value="">Vyber predmet</option>
                            <?php
                            $result = $db->posliPoziadavku("SELECT * FROM Predmet JOIN Vyucuje USING (id_predmetu) WHERE id_ucitela = '$id'");
                            if($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo '<option type="text" class="form-control" value="'.$row['id_predmetu'].'">'.$row['nazov_predmetu'].'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <legend for="newQuestionTopic">Téma</legend>
                    <div class="form-group">
                        <select class="form-control" id="newQuestionTopic" name="newQuestionTopic" style="height: 30px">
                            <option value="">Vyber tému</option>
                        </select>
                    </div>
                </div>
                <legend for="new_question">Otázka:</legend>
                <textarea class="form-control" rows="2" id="new_question"></textarea>
            </div>
            <div class="row">
                <div class="col-sm-10">
                    <legend>Možnosti</legend>
                </div>
                <div class="col-sm-2">
                    <legend>Body</legend>
                </div>
            </div>

            <?php
            for ($x = 0; $x <= 5; $x++) {
                ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-10" id="a . $x"><input type="text" class="form-control"></div>
                        <div class="col-sm-2" id="p . $x"><input type="text" value="0" class="form-control"></div>
                    </div>
                </div>
                <?php
            }
            ?>
            <div></div>
            <div style="width: 15%">
                <legend for="vaha">Váha</legend>
                <textarea class="form-control" rows="1 " id="vaha" style="resize: none"></textarea>
            </div>
            <div>
                <button id="save_button">Uložiť</button>
            </div>
        </div>
    </form>
</div>
