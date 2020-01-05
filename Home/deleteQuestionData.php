<?php
include '../database.php';
$db = new database();
$db->pripoj();
$question_subject_id = $_POST["question_id"];

if(isset($question_subject_id)){
    $deleted_question = $db->posliPoziadavku("SELECT * FROM Otazka JOIN Odpoved USING (id_otazky) WHERE id_otazky = '$question_subject_id'");
    while ($row = mysqli_fetch_assoc($deleted_question)) {
        $id_odpovede = $row["id_odpovede"];
        $db->posliPoziadavku("DELETE FROM Odpoved WHERE id_odpovede = '$id_odpovede'");
    }
    $db->posliPoziadavku("DELETE FROM Otazka WHERE id_otazky = '$question_subject_id'");
}
?>