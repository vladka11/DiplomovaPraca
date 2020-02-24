<?php
include "../database.php";
$db = new database();
$db->pripoj();
session_start();
$logged_id = $_SESSION["userid"];
    if(isset($_POST['idTemy'])){
    $topicID = $_POST['idTemy'];
    $answerResults = $db->posliPoziadavku("select *, sum(bodove_hodnotenie) as dosiahnute_body, max_body*count(DISTINCT id_studenta) as max_body
                                                    FROM Otazka_na_teste
                                                    JOIN Otazka USING (id_otazky)
                                                    JOIN Oznacena_odpoved USING(id_testu, id_otazky)
                                                    WHERE id_testu IN (
                                                                SELECT id_testu FROM Otazka_na_teste 
                                                                JOIN Otazka USING(id_otazky) 
                                                                WHERE id_temy = '$topicID')
                                                    GROUP BY id_otazky");

    while ($row = $answerResults->fetch_assoc()) {
        $rows[] = $row;
    }
    echo json_encode($rows);
}

if(isset($_POST['topic_id'])){
    $topicID = $_POST['topic_id'];
    $teacherID = $logged_id;
    $result = $db->posliPoziadavku(" SELECT *, sum(pocet_bodov) as pocet_bodov, sum(max_body) as max_body, count(id_studenta) as pocet_stud FROM Test 
                                                JOIN Pritomny_student USING (id_testu)
                                                WHERE id_testu IN (
                                                    SELECT id_testu FROM Otazka_na_teste 
                                                    JOIN Otazka USING(id_otazky) 
                                                    WHERE id_temy = '$topicID')
                                                AND id_ucitela = '$teacherID'
                                                GROUP BY id_testu");
    while ($row = $result->fetch_assoc()) {
        $rowss[] = $row;
    }
    if(!empty($rowss)){
        echo json_encode($rowss);
    } else {
        echo 0;
    }
}
?>