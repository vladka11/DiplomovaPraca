<?php
include("onlineNavigationBar.php");

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
    <button id="startQuestions" class="button btn btn-default" type="button" onclick="showQuestions()">Spusti</button>
</div>
<input type="hidden" id="rowCount">
<script type="text/javascript" src="spustiOtazky.js?version2"></script>


<script>
    $(document).ready(function () {
        var data= '<?php echo $id_predmetu;?>';
        console.log("logujem data");
        console.log(data);
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
                    html += "<td align='center'> " + "<h3 class='start'><span style='display:none' onclick='spustiOtazku(this.id)' class='glyphicon glyphicon-play-circle' id='P " + id_otazky + "'></span></h3>" + "</td>";
                    html += "<td align='center'>" + "<h3 class='stop'><span style='color:gray;display:none' onclick='ukonciOtazku(this.id)' class='glyphicon glyphicon-stop' id='S " + id_otazky + "'></h3>" + "</td>";
                    html += "<td align='center'>" + "<h3 class='actualAnswers'><span style='color:gray;display:none' onclick='zobrazVysledky(this.id)' class='glyphicon glyphicon-list-alt' id='A " + id_otazky + "'></h3>" + "</td>";
                    html += "</tr>";
                }
                document.getElementById("data").innerHTML += html;
            } else {
                console.log("nie su tu žiadne datq");
                document.getElementById("noData").innerHTML = "K vybranej téme nie su pridenené žiadne otázky. <br>";
                document.getElementById("noData").innerHTML += "Otázky je možné pridať v offline režime.";
                document.getElementById("noData").style.paddingBottom = "20px";
            }

        },
        error: function (xhr) {

        }
     });
    });
    //zobrazovanie otazok na dashboarde pomocou ajaxu
    /*
    var ajax = new XMLHttpRequest();
    var method = "GET";
    var url = "http://localhost:8080/DiplomovaPraca/Home/questionData.php";
    ajax.open(method, url);
    ajax.send();


    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            console.log(data);

            var html = "";
            for (var a = 0; a < data.length; a++) {
                var text = data[a].text_otazky;
                var id_otazky = data[a].id_otazky;

                html += "<tr>"
                html += "<td class='text'>" + text + "</td>";
                html += "<td align='center'> " + "<h3 class='start'><span style='display:none' onclick='spustiOtazku(this.id)' class='glyphicon glyphicon-play-circle' id='P " + id_otazky + "'></span></h3>" + "</td>";
                html += "<td align='center'>" + "<h3 class='stop'><span style='color:gray;display:none' onclick='ukonciOtazku(this.id)' class='glyphicon glyphicon-stop' id='S " + id_otazky + "'></h3>" + "</td>";
                html += "<td align='center'>" + "<h3 class='actualAnswers'><span style='color:gray;display:none' onclick='zobrazVysledky(this.id)' class='glyphicon glyphicon-list-alt' id='A " + id_otazky + "'></h3>" + "</td>";
                html += "</tr>";
            }
            document.getElementById("data").innerHTML += html;

        }
    };
    */


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
        console.log("hodnota");
        console.log(curVal);
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

    function spustiOtazku(xxx) {
        console.log("Spustam otazku c. " + xxx);

        //Zafarbenie start buttonu na šedo
        document.getElementById(xxx).style.color = "gray";

        //Ziskanie id otazky
        id = xxx.split(" ");
        fullId1= "S ".concat(id[1]);
        fullId2= "A ".concat(id[1]);
        //prefarbenie buttonov ukonču a vysledky na aktívnu zelenu
        document.getElementById(fullId1).style.color = "#0A7E8F";
        document.getElementById(fullId2).style.color = "#0A7E8F";

    }

    function ukonciOtazku(xxx) {
        console.log("Ukoncujem otazku c. " + xxx);
        document.getElementById(xxx).style.color = "gray";

    }

    function zobrazVysledky(xxx) {
        console.log("Zobrazujem vysledky k otazke c. " + xxx);
    }

</script>
</body>
</html>