<?php
$headerTitle = "Pridanie novej otázky";

include("offlineNavigationBar.php");
include ("header.php");
$logged_id = $_SESSION["userid"];
$query = "SELECT * FROM Predmet JOIN Vyucuje USING (id_predmetu) WHERE id_ucitela = '$logged_id '";
$db = new database();
$db->pripoj();
$result = $db->posliPoziadavku($query);

?>
<!DOCTYPE html>
<html>
<div class="container">
    <form role="form" id="newQuestionForm">
        <div style="width: 45%">
        <legend for="newQuestionSubject">Predmet</legend>
        <!-- School dropdown -->
        <div class="form-group">
            <select class="form-control" id="newQuestionSubject" name="newQuestionSubject" style="height: 30px">
                <option value="">Vyber predmet</option>
                <?php
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
        <div class="form-group">
            <legend for="new_question">Otázka:</legend>
            <textarea class="form-control" rows="2" id="new_question"></textarea>
        </div>
        <div class="row">
        <div class="col-sm-10">  <legend>Možnosti</legend></div>
        <div class="col-sm-2">   <legend>Body</legend></div>
        </div>

        <?php
        for  ($x = 0; $x <= 5; $x++) {
            ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-10" id="a . $x"><input type="text" class="form-control"></div>
                    <div class="col-sm-2" id="p . $x"><input type="text"  value="0" class="form-control"></div>
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
    </form>
        <button onclick="addQuestion()">Pridaj</button>
        </div>

</div>

<script type="text/javascript">
            $(document).ready(function(){
                $('#newQuestionSubject').on('change', function() {
                    var idPredmetu = $(this).val();
                    if (idPredmetu) {
                        $.ajax({
                            type: 'POST',
                            url: '../Registration/ajaxSelectBoxData.php',
                            data: 'id_predmetu=' + idPredmetu,
                            success: function (html) {
                                $('#newQuestionTopic').html(html);
                            }
                        });
                    } else {
                        $('#newQuestionTopic').html('<option value="">Vyberte najskôr predmet</option>');
                    }
                })
                });

            function addQuestion(){
               var topic = document.getElementById('newQuestionTopic');
               var topic_id = topic.options[topic.selectedIndex].value;
               var question_text = document.getElementById('new_question').value;
               var weight = document.getElementById('vaha').value;
               var answers = new Array();

                $('#newQuestionForm').find('input:text').each(
                    function(){
                        var input = $(this);
                        if(input.val()){
                            answers.push(input.val());
                    }
                    }
                );
                var jsonString = JSON.stringify(answers);
                if((topic_id)&&(question_text)&&(weight)&&(answers.length>1)){
                    $.ajax({
                        type: 'POST',
                        url: 'addNewQuestions.php',
                        data: 'topic=' + topic_id + '&question=' + question_text + '&answers=' + jsonString + '&   weight=' + weight ,
                        success: function (data) {
                            alert("Otázka bola úspešne pridaná");
                            document.getElementById('new_question').value="";
                            document.getElementById('vaha').value="";
                            document.getElementById('newQuestionSubject').selectedIndex = 0;
                            document.getElementById('newQuestionTopic').selectedIndex = 0;
                            $('#newQuestionForm').find('input:text').val('');
                        }
                    });
                }else{
                    alert("Neboli zadané všetky potrebné údaje");
                }

            }
</script>
</body>
</html>
