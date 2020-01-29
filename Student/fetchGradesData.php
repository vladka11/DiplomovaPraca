<?php
include "../database.php";
$db = new database();
$db->pripoj();
session_start();
$student_id = $_SESSION["userid"];
$result = $db->posliPoziadavku( "SELECT id_predmetu, nazov_predmetu, id_testu, datum_testu, nazov_temy, Pritomny_student.pocet_bodov as score, Test.max_body as max_score
                                            FROM Predmet 
                                            JOIN Tema USING (id_predmetu) 
                                            JOIN Otazka USING (id_temy) 
                                            JOIN Otazka_na_teste USING (id_otazky)
                                            JOIN Test USING (id_testu)
                                            JOIN Pritomny_student USING (id_testu)
                                            WHERE id_studenta = '$student_id'
                                            GROUP BY id_testu");
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}
echo json_encode($rows);
exit();
