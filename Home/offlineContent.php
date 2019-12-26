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
        <div class="row" >
            <div class="col-sm-9"><h3> Učebné materiály </h3> </div>
            <div class="col-sm-3"> <h4><span class="glyphicon glyphicon-plus-sign"></span> Pridaj nový učebný materiál</h4></div>
        </div>
        <hr>
        <p>prednaška.pdf</p>
        <br>
    </div>
    <div class="row">
        <div class="col-sm-9"><h3>Priradené otázky</h3></div>
        <div class="col-sm-3" onclick="addNewQuestion()"><h4><span class="glyphicon glyphicon-plus-sign"></span>  Pridaj novú otázku  </h4></div>
    </div>
    <hr>
    <table class="table" id="tabulkaOtazok" style="display: none">
        <p id="noData"></p>
        <tbody id="data">
        </tbody>
    </table>

    <div class="row">
        <div class="col-sm-8"><h3>Výsledky</h3></div>
        <div class="col-sm-4"><h4>Zobraz všetky výsledky v tejto téme</h4></div>
    </div>
    <hr>
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

                        html += "<tr>"
                        html += "<td class='text'>" + text + "</td>";
                        html += "<td class='text'>" + "Uprav  " + "</td>";
                        html += "<td class='text'>" + "Zmaž" + "</td>";
                        html += "<td align='center'> " + "<h3 class='start'><span style='display:none' onclick='spustiOtazku(this.id)' class='glyphicon glyphicon-play-circle' id='P " + id_otazky + "'></span></h3>" + "</td>";
                        html += "</tr>";
                    }
                    document.getElementById("data").innerHTML += html;
                } else {
                    document.getElementById("noData").innerHTML = "K vybranej téme nie su pridenené žiadne otázky. <br>";
                    document.getElementById("noData").innerHTML += "Pridajte otázku pomocou tlačidla +.";
                    document.getElementById("noData").style.paddingBottom = "20px";
                }

            },
            error: function (xhr) {

            }
        });
    });


</script>
</body>
</html>


