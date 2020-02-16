<?php
$headerTitle = "Zobraznie výsledkov testovej otázky";

include("onlineNavigationBar.php");
include ("header.php");
$logged_id = $_SESSION["userid"];
$id_otazky = $_COOKIE["resultID"];
$id_testu = $_COOKIE["testID"];

$query = "SELECT text_odpovede, count(id_odpovede) as pocet FROM Oznacena_odpoved JOIN Odpoved USING (id_odpovede) WHERE Oznacena_odpoved.id_testu = '$id_testu' AND Oznacena_odpoved.id_otazky = '$id_otazky' GROUP BY (Oznacena_odpoved.id_odpovede)";
$result = $db->posliPoziadavku($query);
?>
<!DOCTYPE html>
<html lang="en-US">
<body>

<h2 id="questionTitle">My Web Page</h2>

<div id="piechart"></div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    // Draw the chart and set the chart values
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Odpoveď', 'Počet označení odpovede'],
            <?php
            while($row = mysqli_fetch_array($result))
            {
                echo "['".$row["text_odpovede"]."', ".$row["pocet"]."],";
            }
            ?>
        ]);

        var options = {'width':750, 'height':500};
        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }
    var questionID = '<?php echo $id_otazky; ?>';

    $.ajax({
        url: "fetchEditQuestionData.php",
        method: "POST",
        data: {clicked_question: questionID},
        dataType: "json",
        success: function (data) {
                document.getElementById('questionTitle').innerText= data.text_otazky;

        }
    });
</script>

</body>
</html>
