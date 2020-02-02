<?php
include '../database.php';
$db = new database();
$db->pripoj();
$subjectName_score = explode(":", strval($_COOKIE["subjectName_score"]));
$subjectName = $subjectName_score[0];
$subject_total_score = $subjectName_score[1];
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="studentDesign.css?version=13">
</head>
<body>
<nav class="navbar">
    <div class="header">
        <div id="header_text">
            <h1 style="padding-left: 30%"><?php echo $subject_total_score ?></h1>
            <div></div>
            <h3 style="padding-left: 10%"><?php echo $subjectName ?></h3>
        </div>
    </div>
</nav>

<div id="all_subject_tests">
    <div id="data"></div>
</div>

<script>
    $(document).ready(function () {
        $.ajax({
            url: "fetchGradesData.php",
            type: "POST",
            success: function (result) {
                var data = JSON.parse(result);
                var html = " ";
                var subject = "<?php echo $subjectName?>";
                for (var a = 0; a < data.length; a++) {
                    if(data[a].nazov_predmetu === subject.toString()){
                        var date = data[a].datum_testu.split("-");
                        var day = date[1];
                        var month = date[2];
                        var year = date[0];
                        date = day + "." + month;
                        html += "<div class= 'col-xs-12 testScore'>";
                        html += "<div class= 'col-xs-2 col-md-2'>" + "<h5 type='text' class='form-text date'>" + date + "</h5>" + "<h5 type='text' class='form-text date'>" + year + "</h5>" + "</div>";
                        html += "<div class= 'col-xs-7 col-md-7'>" + "<h5 type='text' class='form-text topic'>" + data[a].nazov_temy + "</div>";
                        html += "<div class= 'col-xs-3 col-md-3'>" + "<h5 type='text' class='form-text score'>" + data[a].score + "/" + data[a].max_score + "</div>";
                        html += "<br><br><br>";
                        html += "<hr>";
                        html += "</div>";
                    }
                }
                document.getElementById("data").innerHTML += html;
            }
        });
    });


</script>
</body>
</html>