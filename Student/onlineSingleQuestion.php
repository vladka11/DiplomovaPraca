<?php
$onlineQuestionId = $_COOKIE["onlineQuestionId"];
$testId =  $_COOKIE["inputID"];
include "header.php";
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="studentDesign.css?version=17">
</head>
<body>
<div class="question_container">

<div id="question_header">
    <h4 id="topic_name"><span class="glyphicon glyphicon-book"></span></h4>
    <p id="question_id"> </p>
    <hr>
    <p id="question_text"></p>
    <div class="list-group-answers" id="data">
        <div id="noData"></div>
    </div>
    <div id="errorMessage" class="text-danger"> </div>
    <button class="button" id="save_button"  onclick="saveAnwers()" style="margin-top:10px; margin-left: 110px">Ulož</button>
</div>
</div>
<div id="divCounter"></div>

<script>
    //Display answers of the opened question and checkboxes
    var questionID = '<?php echo $onlineQuestionId; ?>';
    var testID = '<?php echo $testId; ?>';
    $(document).ready(function () {
        $.ajax({
            url: "fetchTestData.php",
            data: {"onlineQuestionId": questionID,
            },
            type: "POST",
            success: function (responseText) {
                var data = JSON.parse(responseText);
                var html = "";
                document.getElementById('topic_name').innerHTML += " " + data[0].nazov_predmetu;
                document.getElementById('question_id').innerHTML =  data[0].nazov_temy;
                document.getElementById('question_text').innerHTML  = data[0].text_otazky;
                for (var a = 0; a < data.length; a++) {
                    var text = data[a].text_odpovede;
                    var id = data[a].id_odpovede;
                    html += "<label class='container'>" + text;
                    html += "<input type='checkbox' name='checkboxes' id='" +  id + "'>";
                    html += "<span class='checkmark'></span>";
                    html += "</label>";
                }
                document.getElementById("data").innerHTML += html;
              }
        });
    });
    // Save answers after user tap save button and chose some answers
    function saveAnwers() {
        var answers = [];
        $("input:checkbox").each(function(){
            var $this = $(this);
            if($this.is(":checked")){
                answers.push($this.attr("id"));
         }
        });
        var jsonString = JSON.stringify(answers);
        if(answers.length > 0){
            $.ajax({
                url: "saveAnswer.php",
                data: {"questionID": questionID, "testID":testID, "answers": jsonString, },
                type: "POST",
                success: function (score) {
                    alert(score);
                        alert("Otázka už bola medzičasom uzavretá a nie je možné na nu odpovedať");
                    }
                    window.location = "onlineTestQuestions.php";
                }
            }
        } else {
            document.getElementById("errorMessage").innerHTML= "Nebola zvolená žiadna možnosť";
        }
    }
    </script>
</body>
</html>
