<?php
if (session_id() == '') {
    session_start();
}
$headerTitle = "Zobrazenie všetkých otázok";
$logged_id = $_SESSION["userid"];
include("offlineNavigationBar.php");
include("header.php");


$all_questions = $db->posliPoziadavku("SELECT * FROM Otazka JOIN Tema USING (id_temy) JOIN Predmet USING(id_predmetu) JOIN Vyucuje USING (id_predmetu) 
                                                    WHERE id_ucitela ='$logged_id'");

?>
<html lang="en">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="table.css?version13" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="container">
    <div class="table-responsive">
        <div id="employee_table">
            <table class="table table-bordered" id="all_question_table">
                <tr>
                    <th>ID otázky</th>
                    <th>Text otázky</th>
                    <th>Počet bodov</th>
                    <th>Názov témy</th>
                    <th>Názov predmetu</th>
                    <th>Upraviť</th>
                    <th>Zmazať</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($all_questions)) {
                    ?>
                    <tr>
                        <td><?php echo $row["id_otazky"]; ?></td>
                        <td><?php echo $row["text_otazky"]; ?></td>
                        <td><?php echo $row["max_body"]; ?></td>
                        <td><?php echo $row["nazov_temy"]; ?></td>
                        <td><?php echo $row["nazov_predmetu"]; ?></td>
                        <td><span class='glyphicon glyphicon-edit edit_data'
                                  id='<?php echo $row["id_otazky"]; ?> '></span></td>
                        <td><span class='glyphicon glyphicon-trash delete_data'
                                  id='<?php echo $row["id_otazky"]; ?> '></span></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
</div>
</body>
</html>

<!-- EDIT QUESTION MODAL -->
<div id="dataModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Employee Details</h4>
            </div>
            <div class="modal-body" id="employee_detail">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="add_data_Modal" class="modal fade">
    <!-- Modal Content -->
    <form class="modal-content animate" id="insert_form">
        <div class="container">
            <div class="form-group">
                <div class="modal-body">
                    <div style="width: 45%">
                        <legend for="newQuestionSubject">Predmet</legend>
                        <div class="form-group">
                            <select class="form-control" id="newQuestionSubject" name="newQuestionSubject"
                                    style="height: 30px">
                                <option value="">Vyber predmet</option>
                                <?php
                                $result = $db->posliPoziadavku("SELECT * FROM Predmet JOIN Vyucuje USING (id_predmetu) WHERE id_ucitela = '$logged_id'");
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option type="text" class="form-control" value="' . $row['id_predmetu'] . '">' . $row['nazov_predmetu'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <legend for="newQuestionTopic">Téma</legend>
                        <div class="form-group">
                            <select class="form-control" id="newQuestionTopic" name="newQuestionTopic"
                                    style="height: 30px">
                                <option value="">Vyber tému</option>
                            </select>
                        </div>
                    </div>
                    <legend for="new_question">Otázka:</legend>
                    <textarea class="form-control" rows="2" name="question_text" id="question_text"></textarea>
                </div>
                <div class="row">
                    <div class="col-sm-10">
                        <legend>Možnosti</legend>
                    </div>
                    <div class="col-sm-2">
                        <legend>Body</legend>
                    </div>
                </div>
                <!-- Options -->
                <div class="form-group"><div class="row">
                            <div class="col-sm-10"><input type="text" id="option0" name="option0" class="form-control"></div>
                            <div class="col-sm-2"><input type="text" id="points0" name="points0" class="form-control"></div>
                           <input type="hidden" name="option_id0" id="option_id0"/>
                    </div></div>
                <div class="form-group"><div class="row">
                            <div class="col-sm-10"><input type="text" id="option1" name="option1" class="form-control"></div>
                            <div class="col-sm-2"><input type="text" id="points1" name="points1" class="form-control"></div>
                        <input type="hidden" name="option_id1" id="option_id1"/></div></div>
                <div class="form-group"><div class="row">
                            <div class="col-sm-10"><input type="text" id="option2" name="option2" class="form-control"></div>
                            <div class="col-sm-2"><input type="text" id="points2" name="points2" class="form-control"></div>
                        <input type="hidden" name="option_id2" id="option_id2"/></div></div>
                <div class="form-group"><div class="row">
                            <div class="col-sm-10"><input type="text" id="option3" name="option3" class="form-control"></div>
                            <div class="col-sm-2"><input type="text" id="points3" name="points3" class="form-control"></div>
                        <input type="hidden" name="option_id3" id="option_id3"/></div></div>
                <div class="form-group"><div class="row">
                            <div class="col-sm-10"><input type="text" id="option4" name="option4" class="form-control"></div>
                            <div class="col-sm-2"><input type="text" id="points4" name="points4" class="form-control"></div>
                        <input type="hidden" name="option_id4" id="option_id4"/></div></div>
                <div style="width: 15%">
                    <legend for="vaha">Váha</legend>
                    <textarea class="form-control" rows="1" name="vaha" id="vaha" style="resize: none"></textarea>
                </div>
                <input type="hidden" name="clicked_question_id" id="clicked_question_id" />
                <div>
                    <div class="row">
                        <button id="save_button" type="submit" name="insert" >Uložiť</button>
                        <button type="button" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


<br><br>
<script>
    $(document).ready(function () {
        $('#add').click(function () {
            $('#insert').val("Insert");
            $('#insert_form')[0].reset();
        });
        // Open Edit form modal
        $(document).on('click', '.edit_data', function () {
            //Clear inputs in case there are less options in clicked question and old options stays in inputs
            $(':input').val('');
            //Get id of the clicked question
            var id_otazky = $(this).attr("id");
            $.ajax({
                url: "fetchEditQuestionData.php",
                method: "POST",
                data: {clicked_question: id_otazky},
                dataType: "json",
                success: function (data) {
                    $('#newQuestionSubject').val(data.id_predmetu);
                    // Insert topic in select box
                    $.ajax({
                        type: 'POST',
                        url: '../Registration/ajaxSelectBoxData.php',
                        data: 'id_predmetu=' + data.id_predmetu,
                        success: function (html) {
                            $('#newQuestionTopic').html(html);
                            // Choose correct topic
                            $('#newQuestionTopic').val(data.id_temy);
                        }
                    });
                    // Get question info
                    $('#vaha').val(data.vaha);
                    $('#question_text').val(data.text_otazky);
                    $('#clicked_question_id').val(data.id_otazky);
                    $('#insert').val("Update");
                    //Show modal
                    $('#add_data_Modal').modal('show');
                }
            });
            // Get all options with points
            $.ajax({
                url: "fetchEditQuestionData.php",
                method: "POST",
                data: {show_options: id_otazky},
                dataType: "json",
                success: function (data) {
                    for(var i in data) {
                        var Row = data[i];
                        console.log(Row.text_odpovede);
                        $('#option'+i).val(Row.text_odpovede);
                        $('#points'+i).val(Row.body);
                        $('#option_id'+i).val(Row.id_odpovede);
                    }
                }
            });
        });

        // Update question
        $('#insert_form').on("submit", function(event){
            event.preventDefault();
            if($('#newQuestionSubject').val() == "") { alert("Nie je zvolený predmet.");}
            else if($('#newQuestionTopic').val() == '') { alert("Nie je zvolená téma.");}
            else if($('#vaha').val() == '') { alert("Nie je zadaná váha otázky.");}
            else if($('#question_text').val() == '') { alert("Nie je zadaná otázka.");}
        else
            {
                $.ajax({
                    url: "insertQuestion.php",
                    method: "POST",
                    data: $('#insert_form').serialize(),
                    beforeSend:function(){
                        $('#insert').val("Inserting");
                    },
                    success:function(data){
                        alert("Dáta boli úspešne uložené");
                        $('#insert_form')[0].reset();
                        $('#add_data_Modal').modal('hide');
                        $('#employee_table').html(data);
                        window.location = "allQuestionTable.php";

                    }
                });
            }
    });


        // Delete question
        $(document).on('click', '.delete_data', function () {

            var question_id = $(this).attr("id");
            $.ajax({
                url: "deleteQuestionData.php",
                method: "POST",
                data: {question_id: question_id},
                success: function (data) {
                    alert("Otázka bola úspešne zmazaná");
                    window.location="allQuestionTable.php";
             },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        });

        // Set topic option due to chosen subject
    $('#newQuestionSubject').on('change', function () {
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
        });
    });

</script>
</body>
</html>