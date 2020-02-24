<?php
include("offlineNavigationBar.php");
$predmetAtema = (explode("x", $_COOKIE["predmetTema"]));
if ($predmetAtema == " ") {
    $predmetAtema = "Nazov predmetu x Nazov temy";
}
$id_predmetu = (int)$predmetAtema[0];
$id_temy = (int)$predmetAtema[1];
global $nazov_temy;
global $nazov_predmetu;
$dataPoints = array();
$nazovTema = $db->posliPoziadavku("SELECT nazov_temy, nazov_predmetu FROM Tema JOIN Predmet ON Tema.id_predmetu=Predmet.id_predmetu WHERE Tema.id_temy='$id_predmetu' AND Predmet.id_predmetu = '$id_temy'");
$numrows = mysqli_num_rows($nazovTema);
if ($numrows != 0) {
    while ($row = mysqli_fetch_assoc($nazovTema)) {
        $nazov_temy = $row['nazov_temy'];
        $nazov_predmetu = $row['nazov_predmetu'];
    }
}

$answerResults = $db->posliPoziadavku("select id_otazky, text_otazky, sum(bodove_hodnotenie) as dosiahnute_body, sum(max_body) as max_body  FROM Otazka_na_teste 
                                                  JOIN Oznacena_odpoved USING(id_testu, id_otazky)
                                                  JOIN Otazka USING (id_otazky)
                                                  WHERE id_temy = '$id_predmetu'
                                                  GROUP BY id_otazky");
$answerScore = mysqli_num_rows($answerResults);
if ($answerScore != 0) {
    while ($row = mysqli_fetch_assoc($answerResults)) {
        array_push($dataPoints, array("label" => $row['text_otazky'], "y" => $row['dosiahnute_body']));
    }
}

?>
<!-- Page Content Holder -->
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,300,600,800,900" rel="stylesheet" type="text/css">
    <script src="https://cdn.rawgit.com/kimmobrunfeldt/progressbar.js/0.5.6/dist/progressbar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.4.11/d3.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="table.css?version13" rel="stylesheet" type="text/css"/>


    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</head>
<body>
<div id="content"
">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button type="button" id="sidebarCollapse" class="navbar-btn">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <h4 id="nazovTemy"> <?php echo $nazov_predmetu ?> : <?php echo $nazov_temy ?></h4>
</nav>

<div class="container">
    <div style="display: block">
        <div class="row">
            <div class="col-sm-9"><h3> Učebné materiály </h3></div>
            <div class="col-sm-3"><h4><span class="glyphicon glyphicon-plus-sign"></span> Pridaj nový učebný materiál
                </h4></div>
        </div>
        <hr>
        <p>Miesto pre učebné materiály</p>
        <br>
    </div>
    <div class="row">
        <div class="col-sm-9"><h3>Priradené otázky</h3></div>
        <div class="col-sm-3" onclick="addNewQuestion()"><h4><span class="glyphicon glyphicon-plus-sign"></span> Pridaj
                novú otázku </h4></div>
    </div>
    <hr>
    <table class="table" id="tabulkaOtazok" style="display: none">
        <p id="noData"></p>
        <tbody id="data">
        </tbody>
    </table>

    <div class="row">
        <div class="col-sm-8"><h3>Výsledky</h3></div>
        <div class="col-sm-4 show_data"><h4><span class="glyphicon glyphicon-chevron-right"></span> všetky výsledky v tejto téme</h4></div>
    </div>
    <div class="row">
        <div class="col-sm-8" id="chart-container" style="height: 300px">
            <canvas id="mycanvas"></canvas>
        </div>
        <div class="col-sm-4" style="height: 50px; padding-top: 40px">
            <h4 id="total-score-container"></h4>
            <div id="container"></div>
        </div>

    </div>
    <hr>
</div>

<!--EDIT QUESTION MODAL -->
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
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-10"><input type="text" id="option0" name="option0" class="form-control">
                        </div>
                        <div class="col-sm-2"><input type="text" id="points0" name="points0" class="form-control"></div>
                        <input type="hidden" name="option_id0" id="option_id0"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-10"><input type="text" id="option1" name="option1" class="form-control">
                        </div>
                        <div class="col-sm-2"><input type="text" id="points1" name="points1" class="form-control"></div>
                        <input type="hidden" name="option_id1" id="option_id1"/></div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-10"><input type="text" id="option2" name="option2" class="form-control">
                        </div>
                        <div class="col-sm-2"><input type="text" id="points2" name="points2" class="form-control"></div>
                        <input type="hidden" name="option_id2" id="option_id2"/></div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-10"><input type="text" id="option3" name="option3" class="form-control">
                        </div>
                        <div class="col-sm-2"><input type="text" id="points3" name="points3" class="form-control"></div>
                        <input type="hidden" name="option_id3" id="option_id3"/></div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-10"><input type="text" id="option4" name="option4" class="form-control">
                        </div>
                        <div class="col-sm-2"><input type="text" id="points4" name="points4" class="form-control"></div>
                        <input type="hidden" name="option_id4" id="option_id4"/></div>
                </div>
                <div style="width: 15%">
                    <legend for="vaha">Váha</legend>
                    <textarea class="form-control" rows="1" name="vaha" id="vaha" style="resize: none"></textarea>
                </div>
                <input type="hidden" name="clicked_question_id" id="clicked_question_id"/>
                <div>
                    <div class="row">
                        <button id="save_button" type="submit" name="insert">Uložiť</button>
                        <button type="button" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

    <!-- Show test results from topic -->
    <div id="show_score_modal" class="modal fade">
        <!-- Modal Content -->
        <form class="modal-content animate">
            <div class="container">
                <div class="form-group">
                    <div class="modal-body">
                        <div>

                            <!-- Tests -->
                            <div style="overflow-x:auto;">
                                <table class="table table-bordered" id="all_tests_table">
                                    <tr>
                                        <th>Id testu</th>
                                        <th>Dátum testu</th>
                                        <th>Počet zúčastnených</th>
                                        <th>Počet dosiahnutých bodov</th>
                                        <th>Max počet bodov</th>
                                        <th>Úspešnosť</th>
                                    </tr>
                                </table>
                            </div>

                            <div class="row">
                                <button id="save_button" type="submit" name="insert" data-dismiss="modal">Zavriet
                                </button>
                                <!--<button type="button" data-dismiss="modal">Close</button>-->
                            </div>
                        </div>
                    </div>
                </div>
        </form>
    </div>

    <script>
        $(document).ready(function () {
            var data = '<?php echo $id_predmetu;?>';
            $.ajax({
                url: "http://localhost:8080/DiplomovaPraca/Home/questionData.php",
                data: {
                    "id_temy": data,
                },
                cache: false,
                type: "POST",
                success: function (responseText) {
                    if (responseText.length > 5) {
                        document.getElementById("tabulkaOtazok").style.display = "block";
                        var data = JSON.parse(responseText);
                        var html = "";
                        for (var a = 0; a < data.length; a++) {
                            var text = data[a].text_otazky;
                            var id_otazky = data[a].id_otazky;

                            html += "<tr>";
                            html += "<td class='text'>" + text + "</td>";
                            html += "<td class='text edit_data' id='" + id_otazky + "' onclick='editQuestion(this.id)'>" + "Uprav  " + "</td>";
                            html += "<td class='text'>" + "Zmaž" + "</td>";
                            html += "<td align='center'> " + "<h3 class='start'><span style='display:none' onclick='spustiOtazku(this.id)' class='glyphicon glyphicon-play-circle' id='P " + id_otazky + "'></span></h3>" + "</td>";
                            html += "</tr>";
                        }
                        document.getElementById("data").innerHTML += html;
                    } else {
                        document.getElementById("noData").innerHTML = "K vybranej téme nie su pridelené žiadne otázky. <br>";
                        document.getElementById("noData").innerHTML += "Pridajte otázku pomocou tlačidla +.";
                        document.getElementById("noData").style.paddingBottom = "20px";
                    }

                },
                error: function (xhr) {

                }
            });
            let sumScore = 0;
            let maxScore = 0;
            $.ajax({
                url: "getResultData.php",
                method: "POST",
                data: {
                    "idTemy": data,
                },
                success: function (data) {
                    let results = JSON.parse(data);
                    let question = [];
                    let score = [];
                    for (let a = 0; a < results.length; a++) {
                        let Row = results[a];
                        let percentage = (Row.dosiahnute_body / Row.max_body * 100).toFixed(2);
                        question.push(Row.text_otazky);
                        score.push(percentage);
                        sumScore += parseInt(Row.dosiahnute_body);
                        maxScore += parseInt(Row.max_body);
                    }
                    let totalScore = sumScore / maxScore * 100;
                    document.getElementById('total-score-container').innerText = "Celková úspešnosť testu:" + totalScore.toFixed(2) + "%";
                    var chartdata = {
                        labels: question,
                        datasets: [
                            {
                                label: 'Úspešnosť jednotlivých otázok',
                                backgroundColor: 'rgba(42,149,157,0.75)',
                                borderColor: 'rgba(200, 200, 200, 0.75)',
                                hoverBackgroundColor: 'rgb(35,128,135)',
                                data: score
                            }
                        ]
                    };
                    var ctx = $("#mycanvas");
                    var barGraph = new Chart(ctx, {
                        type: 'bar',
                        data: chartdata,
                        options: {
                            maintainAspectRatio: false,
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        min: 0,
                                        max: 100,
                                        callback: function (value) {
                                            return value + "%"
                                        }
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: "Percentuálna úspešnosť"
                                    }
                                }]
                            }
                        }
                    });
                },
                error: function (data) {
                    console.log(data);
                }
            });
            // bar.animate(1.0);
        });

        // Open Edit form modal
        function editQuestion(id_otazky) {
            //Clear inputs in case there are less options in clicked question and old options stays in inputs
            $(':input').val('');
            //Get id of the clicked question
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
                    for (var i in data) {
                        var Row = data[i];
                        console.log(Row.text_odpovede);
                        $('#option' + i).val(Row.text_odpovede);
                        $('#points' + i).val(Row.body);
                        $('#option_id' + i).val(Row.id_odpovede);
                    }
                }
            });
        }

        // Update question
        $('#insert_form').on("submit", function (event) {
            event.preventDefault();
            if ($('#newQuestionSubject').val() == "") {
                alert("Nie je zvolený predmet.");
            } else if ($('#newQuestionTopic').val() == '') {
                alert("Nie je zvolená téma.");
            } else if ($('#vaha').val() == '') {
                alert("Nie je zadaná váha otázky.");
            } else if ($('#question_text').val() == '') {
                alert("Nie je zadaná otázka.");
            } else {
                $.ajax({
                    url: "insertQuestion.php",
                    method: "POST",
                    data: $('#insert_form').serialize(),
                    beforeSend: function () {
                        $('#insert').val("Inserting");
                    },
                    success: function (data) {
                        alert("Dáta boli úspešne uložené");
                        $('#insert_form')[0].reset();
                        $('#add_data_Modal').modal('hide');
                        $('#employee_table').html(data);
                        window.location = "allQuestionTable.php";

                    }
                });
            }
        });

        $(document).on('click', '.show_data', function () {
            var data = '<?php echo $id_predmetu;?>';
            var teacher_id = '<?php echo $logged_id;?>';
            $.ajax({
                type: 'POST',
                url: 'getResultData.php',
                data: 'teacher_id=' + teacher_id + '&topic_id=' + data,
                dataType: "json",
                success: function (data) {
                    if (data == '0') {
                        alert("Žiaden test z danej témy nebol spustený.");
                    } else {
                        $("#all_tests_table").find("tr:gt(0)").remove();
                        for (var a in data) {
                            var Row = data[a];
                            var score = (Row.pocet_bodov/Row.max_body*100).toFixed(2) + "%";
                            $('#all_tests_table').append('<tr><td> ' + Row.id_testu + '</td>' +
                                '                             <td> ' + Row.datum_testu + '</td>' +
                                '                             <td> ' + Row.pocet_stud + '</td>' +
                                '                             <td> ' + Row.pocet_bodov + '</td>' +
                                '                             <td> ' + Row.max_body + '</td>' +
                                '                             <td> ' + score + '</td></tr>');

                        }
                        $('#show_score_modal').modal('show');
                    }
                }
            });
        });
    </script>
</body>
</html>


