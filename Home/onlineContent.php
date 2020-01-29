<?php
include("onlineNavigationBar.php");
if (session_id() == '') {
    session_start();
}
$logged_id = $_SESSION["userid"];

$predmetAtema = (explode("x", $_COOKIE["predmetTema"]));
if ($predmetAtema == " ") {
    $predmetAtema = "Nazov predmetu x Nazov temy";
}
$id_predmetu = (int)$predmetAtema[0];
$id_temy = (int)$predmetAtema[1];
global $nazov_temy;
global $nazov_predmetu;
$nazovTema = $db->posliPoziadavku("SELECT nazov_temy, nazov_predmetu FROM Tema JOIN Predmet ON Tema.id_predmetu=Predmet.id_predmetu WHERE Tema.id_temy='$id_predmetu' AND Predmet.id_predmetu = '$id_temy'");
$numrows = mysqli_num_rows($nazovTema);
if ($numrows != 0) {
    while ($row = mysqli_fetch_assoc($nazovTema)) {
        $nazov_temy = $row['nazov_temy'];
        $nazov_predmetu = $row['nazov_predmetu'];
    }
}
?>
<!-- Page Content Holder -->
<html>
<head>
<body>
<div id="content"">
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
        <h3> Učebné materiály </h3>
        <hr>
        <p>prednaška.pdf</p>
        <br>
    </div>

    <h3>Priradené otázky</h3>
    <table class="table" id="tabulkaOtazok" style="display: none">
        <tr>
            <th>Otázka</th>
            <th>Spustenie</th>
            <th>Ukončenie</th>
            <th>Výsledky</th>
        </tr>
        <p id="noData"></p>
        <tbody id="data">
        </tbody>
    </table>

    <h3><span class="glyphicon glyphicon-play-circle"></span> Spustenie testu</h3>
    <hr>
    <div class="timer" id="timer">
        <div class="text">
            <p class="text">Čas na zodpovedanie otázky</p>
        </div>
        <div class="rangeall">
            <div class="range">
                <input type="range" min="1" max="7" steps="1" value="1">
            </div>
            <ul class="range-labels">
                <li class="active selected">Bez limitu</li>
                <li>15 sec</li>
                <li>30 sec</li>
                <li>45 sec</li>
                <li>1 min</li>
                <li>1,5 min</li>
                <li>2 min</li>
            </ul>
        </div>
    </div>
    <br>
    <div class="answers" id="answers">
        <p class="text">Zobrazenie správnych odpovedí pre študentov</p>
        <label class="switch">
            <input type="checkbox">
            <span class="slider round"></span>
        </label>
    </div>
    <button id="startQuestions" class="button btn btn-default" type="submit" onclick="showQuestions()">Spusti</button>
</div>
<!-- Hidden element with created test id-->
<input type="hidden" id="new_test_id">
<script type="text/javascript" src="spustiOtazky.js?version3"></script>


<script>

    //Show question data with hidden icons for actions
    $(document).ready(function () {
        var data= '<?php echo $id_predmetu;?>';
    $.ajax({
        url: "http://localhost:8080/DiplomovaPraca/Home/questionData.php",
        data: {
            "id_temy": data,
        },
        cache: false,
        type: "POST",
        success: function (responseText) {
            if(responseText.length > 5){
                document.getElementById("tabulkaOtazok").style.display="block";
                var data = JSON.parse(responseText);
                var html = "";
                for (var a = 0; a < data.length; a++) {
                    var text = data[a].text_otazky;
                    var id_otazky = data[a].id_otazky;

                    html += "<tr>"
                    html += "<td class='text'>" + text + "</td>";
                    html += "<td align='center'> " + "<h3 class='start'><span style='display:none' onclick='startQuestion(this.id)' class='glyphicon glyphicon-play-circle' id='P " + id_otazky + "'></span></h3>" + "</td>";
                    html += "<td align='center'>" + "<h3 class='stop'><span style='color:gray;display:none' onclick='stopQuestion(this.id)' class='glyphicon glyphicon-stop' id='S " + id_otazky + "'></h3>" + "</td>";
                    html += "<td align='center'>" + "<h3 class='actualAnswers'><span style='color:gray;display:none' onclick='showResults(this.id)' class='glyphicon glyphicon-list-alt' id='A " + id_otazky + "'></h3>" + "</td>";
                    html += "</tr>";
                }
                document.getElementById("data").innerHTML += html;
            } else {
                document.getElementById("noData").innerHTML = "K vybranej téme nie su pridelené žiadne otázky. <br>";
                document.getElementById("noData").innerHTML += "Otázky je možné pridať v offline režime.";
                document.getElementById("noData").style.paddingBottom = "20px";
            }

        },
        error: function (xhr) {

        }
     });
    });
    //time slider
    var sheet = document.createElement('style'),
        $rangeInput = $('.range input'),
        prefs = ['webkit-slider-runnable-track', 'moz-range-track', 'ms-track'];

    document.body.appendChild(sheet);

    var getTrackStyle = function (el) {
        var curVal = el.value,
            val = (curVal - 1) * 16.666666667,
            style = '';
        // Set active label
        $('.range-labels li').removeClass('active selected');

        var curLabel = $('.range-labels').find('li:nth-child(' + curVal + ')');
        curLabel.addClass('active selected');
        curLabel.prevAll().addClass('selected');

        // Change background gradient
        for (var i = 0; i < prefs.length; i++) {
            style += '.range {background: linear-gradient(to right, #37adbf 0%, #37adbf ' + val + '%, #fff ' + val + '%, #fff 100%)}';
            style += '.range input::-' + prefs[i] + '{background: linear-gradient(to right, #37adbf 0%, #37adbf ' + val + '%, #b2b2b2 ' + val + '%, #b2b2b2 100%)}';
        }
        return style;
    }

    $rangeInput.on('input', function () {
        sheet.textContent = getTrackStyle(this);
    });

    // Change input value on label click
    $('.range-labels li').on('click', function () {
        var index = $(this).index();
        $rangeInput.val(index + 1).trigger('input');

    });

    //create new test in database
    $(document).on('click', '#startQuestions', function () {
        $.ajax({
            type: 'POST',
            url: 'createNewTest.php',
            data: 'createTest=' + "new test",
            success: function (data) {
                 //save test id in hidden element
                 document.getElementById('new_test_id').value=data;
                }
        });
    });

</script>
</body>
</html>