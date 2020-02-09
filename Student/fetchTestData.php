<?php
include "../database.php";
$db = new database();
$db->pripoj();
session_start();
$user_id = $_SESSION["userid"];

// Display all question in test
if (isset($_POST['testID'])){
    $testID = $_POST['testID'];
    $result = $db->posliPoziadavku( "SELECT nazov_predmetu, nazov_temy, id_otazky, text_otazky, text_odpovede, otvoreny, spustena from Otazka 
                                           JOIN Otazka_na_teste USING(id_otazky) 
                                           JOIN Test USING (id_testu) 
                                           JOIN Odpoved USING (id_otazky) 
                                           JOIN Tema USING (id_temy) 
                                           JOIN Predmet USING (id_predmetu) 
                                           WHERE id_testu = '$testID'
                                           AND  otvoreny = '1'
                                           GROUP BY id_otazky");
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    echo json_encode($rows);
    exit();
}
// Display all answers in test question
if (isset($_POST['onlineQuestionId'])){
    $questionId = $_POST['onlineQuestionId'];
    $result = $db->posliPoziadavku( "SELECT nazov_predmetu, nazov_temy, id_otazky, text_otazky, text_odpovede, id_odpovede, otvoreny, spustena from Otazka 
                                           JOIN Otazka_na_teste USING(id_otazky) 
                                           JOIN Test USING (id_testu) 
                                           JOIN Odpoved USING (id_otazky) 
                                           JOIN Tema USING (id_temy) 
                                           JOIN Predmet USING (id_predmetu) 
                                           WHERE id_otazky = '$questionId'");
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    echo json_encode($rows);
    exit();
}
// Close question
if (isset($_POST['onlineQuestionIdClosed'])){
    $questionId = $_POST['onlineQuestionIdClosed'];
    $result = $db->posliPoziadavku( "SELECT nazov_predmetu, nazov_temy, id_otazky, text_otazky, text_odpovede, otvoreny, spustena from Otazka 
                                           JOIN Otazka_na_teste USING(id_otazky) 
                                           JOIN Test USING (id_testu) 
                                           JOIN Odpoved USING (id_otazky) 
                                           JOIN Tema USING (id_temy) 
                                           JOIN Predmet USING (id_predmetu) 
                                           WHERE id_otazky = '$questionId'");
}

// Check if question was answered or not
if(isset($_POST['checkedQuestionID'])){
    $questionId = $_POST['checkedQuestionID'];
    $testID = $_POST['checkedtestID'];
    //$result = $db->posliPoziadavku("SELECT * FROM Oznacena_odpoved WHERE id_testu = '$testID' AND id_otazky = '$questionId' AND id_studenta = '$user_id' AND id_testu_1 = '$testID' LIMIT '1'");
    $results = $db->posliPoziadavku("SELECT * FROM Oznacena_odpoved 
                                              WHERE id_testu = '$testID' 
                                              AND id_otazky = '$questionId' 
                                              AND id_studenta = '$user_id' 
                                              AND id_testu_1 = '$testID'");
    $row = mysqli_fetch_row($results);
    echo json_encode($row);

}



