<?php
session_start();
include "../database.php";
$db = new database();
$db->pripoj();
$logged_id = $_SESSION["userid"];

if (isset($_POST['testID']) and (isset($_POST['questionID']))) {
    $testID = $_POST['testID'];
    $questionID = $_POST['questionID'];
    $timeout = $_POST['timeout'];
    if ($timeout == "true") {
        $insertQuery = $db->posliPoziadavku("INSERT INTO Oznacena_odpoved VALUES ('$testID', '$questionID', '$logged_id ','$testID',NULL,'0')");
    } else if ($timeout == "false") {
        $my_array_data = json_decode(($_POST['answers']), true);
        for ($i = 0; $i <= sizeof($my_array_data); $i++) {
            if (!empty($my_array_data[$i])) {
                $insertQuery = $db->posliPoziadavku("INSERT INTO Oznacena_odpoved VALUES ('$testID', '$questionID', '$logged_id','$testID','$my_array_data[$i]','0')");
            }
        }
    }
}
return $insertQuery;
// Premennu stav pridavam kvoli tomu, že by študent nestihol odpovedať na otazku, treba kontrolovať či už študent odpovedal na otazku, kontrola podľa "id_odpoved",
// ak by ale nestihol odpovedať, tuež by to bolo prazdne a potom by to mohlo posobiť že ešte neodpovedal ..aj ked nič neoznačil