<?php
if (session_id() == '') {
    session_start();
}
$headerTitle = "Zobrazenie všetkých otázok";
$logged_id = $_SESSION["logged_id"];
include("offlineNavigationBar.php");
include("header.php");
include ("modalQuestion.php");

$all_questions = $db->posliPoziadavku("SELECT * FROM Otazka JOIN Tema USING (id_temy) JOIN Predmet USING(id_predmetu) JOIN Vyucuje USING (id_predmetu) 
                                                    WHERE id_ucitela ='$logged_id'");

?>
<html lang="en">
<head>
    <link href="table.css?version6" rel="stylesheet" type="text/css"/>
</head>
<body>
<table id="all_question_table">
    <tr>
        <th>ID otázky</th>
        <th>Text otázky</th>
        <th>Počet bodov</th>
        <th>Názov témy</th>
        <th>Názov predmetu</th>
        <th>Upraviť</th>
    </tr>
    <?php
        while ($row = mysqli_fetch_assoc($all_questions)) {
            ?>
            <tr>
                <td><?php echo $row["id_otazky"]; ?></td>
                <td><?php echo $row["text_otazky"]; ?></td>
                <td><?php echo $row["max_body"]; ?></td>
                <td><?php echo $row["nazov_temy"]; ?></td>
                <td><?php echo $row["nazov_predmetu"]; ?></td>
                <td><span onclick='editQuestion(this.id)' class='glyphicon glyphicon-edit'
                          id='<?php echo $row["id_otazky"]; ?> '></span></td>
            </tr>
            <?php
        }
    ?>
</table>
    <br><br>
    <script>
        function editQuestion(id_otazky) {
            alert(id_otazky);
            document.cookie = "id_otazky=" + id_otazky;
            document.getElementById('id01').style.display='block';
        }

        // Get the modal
        var modal = document.getElementById('id01');

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        $(document).ready(function(){
            $('#newQuestionSubject').on('change', function() {
                var idPredmetu = $(this).val();
                if (idPredmetu) {
                    $.ajax({
                        type: 'POST',
                        url: '../Registration/ajaxSelectBoxData.php',
                        data: 'id_predmetu=' + idPredmetu,
                        success: function (html) {
                            $('#newQuestionTopic').html(html);
                        }
                    });
                } else {
                    $('#newQuestionTopic').html('<option value="">Vyberte najskôr predmet</option>');
                }
            })
        });

    </script>
</body>
</html>