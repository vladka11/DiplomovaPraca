    <?php
session_start();
$logged_id = $_SESSION["userid"];

include("../database.php");
$db = new database();
$db->pripoj();

$today=date("Y-m-d");
if(!empty($_POST["topicId"])){
    $topicID = $_POST["topicId"];
    $totalScore=0;
    $getScore= $db->posliPoziadavku("SELECT * From Otazka WHERE id_temy= '$topicID'");
    while($row = $getScore->fetch_assoc()){
            $totalScore += $row['max_body'];
        }
    $db->posliPoziadavku("INSERT INTO Test(id_ucitela, datum_testu,otvoreny,max_body) VALUES('$logged_id','$today','1','$totalScore')");
    $test_id=$db->getLastId();
    echo $test_id;
}

if(!empty($_POST["clicked_question_id"])){
    $question_id=$_POST["clicked_question_id"];
    $test_id=$_POST["test_id"];
    $db->posliPoziadavku("INSERT INTO Otazka_na_teste(id_testu, id_otazky, spustena) VALUES('$test_id','$question_id','1')");
}