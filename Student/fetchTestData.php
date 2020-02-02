<?php
include "../database.php";
$db = new database();
$db->pripoj();

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
if (isset($_POST['onlineQuestionId'])){
    $questionId = $_POST['onlineQuestionId'];
    $result = $db->posliPoziadavku( "SELECT nazov_predmetu, nazov_temy, id_otazky, text_otazky, text_odpovede, otvoreny, spustena from Otazka 
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





