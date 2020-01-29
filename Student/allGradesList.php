<?php
include "./header.php";
include '../database.php';
$db = new database();
$db->pripoj();
?>
<div id="all_grades_list">
    <div id="data"></div>
</div>
<script>
    $(document).ready(function () {
        $.ajax({
            url: "fetchGradesData.php",
            type: "POST",
            success: function (result) {
                var data = JSON.parse(result);
                var html = "";
                var html2 = "";
                var $sum_score = 0;
                var $max_score = 0;
                var subject_id = data[0].id_predmetu;
                for (var a = 0; a < data.length; a++) {
                    if(data[a].id_predmetu === subject_id){
                        $sum_score += parseInt(data[a].score);
                        $max_score += parseInt(data[a].max_score);
                        if(a === (data.length-1)){
                            score = calculatePercentage($sum_score, $max_score);
                            showSubjectScore(data[a].nazov_predmetu, score);
                        }
                    } else {
                        var score = calculatePercentage($sum_score, $max_score);
                        showSubjectScore(data[a-1].nazov_predmetu, score);
                        subject_id = data[a].id_predmetu;
                        $sum_score= parseInt(data[a].score);
                        $max_score= parseInt(data[a].max_score);
                        // Only one test from subject
                        if(a === (data.length-1)){
                            score = calculatePercentage(data[a].score, data[a].max_score);
                            showSubjectScore(data[a].nazov_predmetu, score);
                        }
                    }
                }
            },
        })
    });
    
    function calculatePercentage(score, max_score) {
        alert(score + "/" + max_score)
        return Math.round((score/max_score)*100) + "%";
    }

    function showSubjectScore(subject_Name, score){
        var html = "";
        html += "<h6>"+ subject_Name +"</h6>";
        html += "<div class='progress'>";
        html += "<div class='progress-bar' role='progressbar' aria-valuenow='70' aria-valuemin='0' aria-valuemax='100' style='width:"+ score  +"'>" + score + "</div>";
        html += "</tr>";
        document.getElementById("data").innerHTML += html;
    }


</script>