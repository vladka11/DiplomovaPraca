<?php
//fetch data to edit question form
include '../database.php';
$db = new database();
$db->pripoj();
if(isset($_POST["clicked_question"]))
{
    $clicked_question_data = $db->posliPoziadavku("SELECT * FROM Otazka JOIN Tema USING(id_temy) JOIN Predmet USING(id_predmetu)
                                                    WHERE id_otazky ='".$_POST["clicked_question"]."'");
    $row = mysqli_fetch_array($clicked_question_data);
    echo json_encode($row);
}

if(isset($_POST["show_options"]))
{
    $clicked_question_data = $db->posliPoziadavku("SELECT * FROM Odpoved WHERE id_otazky ='".$_POST["show_options"]."'");
    while ($row = $clicked_question_data->fetch_assoc()) {
        $rows[] = $row;
    }
    echo json_encode($rows);
}
?>
<?php
