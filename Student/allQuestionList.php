<?php
include "./header.php";
include '../database.php';
$db = new database();
$db->pripoj();

$predmetAtema = (explode("x", $_COOKIE["predmetTema"]));
if ($predmetAtema == " ") {
    $predmetAtema = "Nazov predmetu x Nazov temy";
}
$id_temy = (int)$predmetAtema[0];
$id_predmetu = (int)$predmetAtema[1];
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
        $(document).ready(function () {
            var data = '<?php echo $id_temy;?>';
            $.ajax({
                url: "fetchTopicData.php",
                data: {"id_temy": data,
                },
                type: "POST",
                dataType: "json",
                success: function (data) {
                    document.getElementById('subject_name').innerHTML += "   " +  data.nazov_predmetu;
                    document.getElementById('topic_name').innerHTML= data.nazov_temy;
                }
            });


            $.ajax({
                url: "http://localhost:8080/DiplomovaPraca/Home/questionData.php",
                data: {
                    "id_temy": data,
                },
                cache: false,
                type: "POST",
                success: function (responseText) {
                    if (responseText.length > 5) {
                        var data = JSON.parse(responseText);
                        var html = "";
                        for (var a = 0; a < data.length; a++) {
                            var text = data[a].text_otazky;
                            var id_otazky = data[a].id_otazky;

                            html += "<tr>"
                            html += "<p class='list-group-item'>" + text + "</p>";
                            html += "</tr>";
                        }
                        document.getElementById("data").innerHTML += html;
                    } else {
                        document.getElementById("noData").innerHTML = "K vybranej téme nie su priradené žiadne otázky. <br>";
                        document.getElementById("noData").style.paddingBottom = "20px";
                    }

                },
                error: function (xhr) {

                }
            });
        });
    </script>