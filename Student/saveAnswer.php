<?php
session_start();
include "../database.php";
$db = new database();
$db->pripoj();
$logged_id = $_SESSION["userid"];

if (isset($_POST['testID']) and (isset($_POST['questionID']))) {
    $testID = $_POST['testID'];
    $questionID = $_POST['questionID'];
    $totalScore = 0;
    $my_array_data = json_decode(($_POST['answers']), true);
    // Loop through the array with selected answers
    for ($i = 0; $i <= sizeof($my_array_data); $i++) {
        if (!empty($my_array_data[$i])) {
            // Get score for selected answer in "Odpoved" table
            $getScore = $db->posliPoziadavku("SELECT * FROM Odpoved WHERE id_odpovede ='$my_array_data[$i]'");
            $score = mysqli_fetch_object($getScore);
            // Get weight of answered question
            $getWeight = $db->posliPoziadavku("SELECT * FROM Otazka WHERE id_otazky ='$questionID'");
            $data = mysqli_fetch_object($getWeight);
            $getStatus = $db->posliPoziadavku("SELECT * FROM Otazka_na_teste WHERE id_otazky ='$questionID' AND id_testu ='$testID'");
            $status = mysqli_fetch_object($getStatus);
            if ($status->spustena == '1') {
                // If answer is not correct
                if ($score->body == 0) {
                    $scoree = -1 * ($data->vaha);
                    $totalScore += $scoree;
                } // If answer is correct
                else {
                    $scoree = ($score->body) * ($data->vaha);
                    $totalScore += $scoree;
                }
                // Insert selected answer into database
               // if($scoree < 0){
                 //   $scoree=0;
                //}
                $insertQuery = $db->posliPoziadavku("INSERT INTO Oznacena_odpoved VALUES ('$testID', '$questionID', '$logged_id','$testID','$my_array_data[$i]','$scoree')");
                // $insertQuery = $db->posliPoziadavku("INSERT INTO Oznacena_odpoved VALUES ('47', '2', '1','47 ','8','0')");
            } else {
                // Question has been already closed, too late :)
                $totalScore = -999;
            }
        }
    }

        // If student has more than 0 points for question
        if ($totalScore > 0) {
            $updateQuery = $db->posliPoziadavku("UPDATE Pritomny_student SET pocet_bodov =  pocet_bodov + '$totalScore' WHERE id_testu = '$testID' AND id_studenta = '$logged_id'");
        }
}
echo $totalScore;
// Premennu stav pridavam kvoli tomu, že by študent nestihol odpovedať na otazku, treba kontrolovať či už študent odpovedal na otazku, kontrola podľa "id_odpoved",
// ak by ale nestihol odpovedať, tuež by to bolo prazdne a potom by to mohlo posobiť že ešte neodpovedal ..aj ked nič neoznačil