<?php
$onlineQuestionId = $_COOKIE["onlineQuestionId"];
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
    <p id="demo"></p>
    <button class="button" id="save_button" style="margin-top:10px; margin-left: 110px">Ulož</button>
</div>
</div>

<script>
    $(document).ready(function () {
    var questionID = '<?php echo $onlineQuestionId; ?>';
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
                   // html += "<div class= 'col-xs-12 question_line'>";
                    //html += "<div class= 'col-xs-2 col-md-3 list-group-letter'>" + "<h5 type='text'>" + "A" + "</h5></div>";
                    //tml += "<div class= 'col-xs-10 col-md-9 list-group-answer'>" + "<h5 type='text'>" + text + "</h5></div>";
                    //html += "</div>";
                    html += "<label class='container'>" + text;
                    html += "<input type='checkbox'>";
                    html += "<span class='checkmark'></span>";
                    html += "</label>";
                }
                document.getElementById("data").innerHTML += html;
              }
        });
    });

    var timeleft = 11   ;
    var downloadTimer = setInterval(function(){
        timeleft--;
        document.getElementById("demo").textContent = timeleft;
        if(timeleft <= 0){
            clearInterval(downloadTimer);
            // TODO Close question in database to avoid page refresh
            document.getElementById('save_button').disabled = true;
            document.getElementById('save_button').style.backgroundColor='#D3D3D3';
            alert("Čas vypršal!");
        }
    },1000);
    </script>
</body>
</html>
