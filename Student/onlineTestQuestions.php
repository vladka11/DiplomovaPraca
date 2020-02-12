<?php
include "./header.php";
include '../database.php';
$db = new database();
$db->pripoj();
$id_testu = $_COOKIE["inputID"];
?>

<div class="question_container">
    <div id="topic_header">
        <h4 id="subject_name"><span class="glyphicon glyphicon-book"></span></h4>
        <p id="topic_name" style="margin-bottom: 2px">Názov témy</p>
        <hr>
    </div>
    <div class="list-group" id="data">
        <div id="noData"></div>
    </div>

    <script>
        //Show questions in opened tests
        var data = '<?php echo $id_testu;?>';
        $(document).ready(function () {
            $.ajax({
                url: "fetchTestData.php",
                data: {
                    "testID": data,
                },
                type: "POST",
                success: function (response) {
                    if(response!=="null"){
                   var html = "";
                    var data = JSON.parse(response);
                    document.getElementById('subject_name').innerHTML += "   " + data[0].nazov_predmetu;
                    document.getElementById('topic_name').innerHTML = data[0].nazov_temy;

                    for (var a = 0; a < data.length; a++) {
                        var text = (data[a].text_otazky.replace(/^(.{40}[^\s]*).*/, "$1") + " \n");
                        if ((data[a].text_otazky).length > 40) {
                            text += "...";
                        }
                        var id_otazky = data[a].id_otazky;
                        html += "<tr>";
                        // Display only if teacher turn on this question
                        if (data[a].spustena === '1') {
                            html += "<p class='list-group-item' id='" + id_otazky + "' style='background-color:#2BA7AF' onclick='showOnlineQuestion(this.id)'>" + text + "<span class='glyphicon glyphicon-menu-right'></span>" + "</p>";
                        } else {
                            html += "<p class='list-group-item'>" + text + "</p>";
                            html += "</tr>";
                        }
                    }
                    document.getElementById("data").innerHTML += html;
                } else {
                        document.getElementById("topic_name").innerHTML = "Otázky v teste ešte neboli spustené. Prosím počkajte na pokyn vyučujúceho.";
                    }
                }
            });
        });

        function showOnlineQuestion(id) {
            //Check if question has not been already answered before
            $.ajax({
                url: "fetchTestData.php",
                data: {"checkedtestID": data, "checkedQuestionID": id,},
                type: "POST",
                success: function (response) {
                    if (response === "null") {
                        document.cookie = "onlineQuestionId= " + id;
                        window.location = "../Student/onlineSingleQuestion.php";
                    } else {
                       alert("Otazka už bola zaznamenaná");
                    }
                }
            });

        }
    </script>