<?php
//fetch data to edit question form
include '../database.php';
$db = new database();
$db->pripoj();
if(isset($_POST["student_id"]))
{
    $clicked_student = $db->posliPoziadavku("SELECT nazov_predmetu, id_predmetu, nazov_temy, datum_testu, id_testu, pocet_bodov, Test.max_body 
                                                        FROM Pritomny_student JOIN Test USING(id_testu) 
                                                        JOIN Otazka_na_teste USING(id_testu) 
                                                        JOIN Otazka USING (id_otazky) 
                                                        JOIN Tema USING(id_temy) 
                                                        JOIN Predmet USING (id_predmetu) 
                                                        WHERE id_studenta ='".$_POST["student_id"]."' 
                                                        AND id_predmetu  ='".$_POST["subject_id"]."' 
                                                        GROUP BY id_testu");
    while ($row = $clicked_student->fetch_assoc()) {
        $rows[] = $row;
    }
    if(!empty($rows)){
        echo json_encode($rows);
    } else {
        echo 0;
    }

}

?>
<?php
