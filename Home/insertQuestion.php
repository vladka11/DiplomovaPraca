<?php
include '../database.php';
$db = new database();
$db->pripoj();

if (session_id() == '') {
    session_start();
}
$logged_id = $_SESSION["logged_id"];

if(!empty($_POST))
{
    // Get new data
    $output = '';
    $message = '';
    $question_subject_id =  $_POST["newQuestionSubject"];
    $question_topic_id = $_POST["newQuestionTopic"];
    $weight = $_POST["vaha"];
    $question_text =  $_POST["question_text"];
    $question_id =  $_POST["clicked_question_id"];
    if($_POST["clicked_question_id"] != '')

    // Save question data
    {
        $query = "  
           UPDATE Otazka
           SET text_otazky='$question_text',
           id_temy ='$question_topic_id' ,
           vaha ='$weight'
           WHERE id_otazky='$question_id'";
        $message = 'Data Updated';
    }
    $db->posliPoziadavku($query);
    $test = 3;
    //Save new options
    for ($x = 0; $x <= 4; $x++) {
        $text= $_POST["option$x"];
        $body= $_POST["points$x"];
        $id= $_POST["option_id$x"];
    //TODO Kontrola či niečo nové nepridal/nezmazal (možnosť)
        //Check if there is new option - insert needs to be done
        if((!empty($text))&&(empty($id))){
            $body = ($body > 0) ? $body : 0;
            $spravnost = ($body > 0) ? 'TRUE' : 'FALSE';
            $db->posliPoziadavku("INSERT INTO Odpoved(id_otazky,text_odpovede,spravnost,body) VALUES ('$question_id','$text','$spravnost','$body')");
            $test = 1;
        } else
            // Check if user does not delete one of the answer
            if(empty($text)&&(!empty($id))) {
                $db->posliPoziadavku("DELETE FROM Odpoved WHERE id_odpovede = '$id'");
            }
            //Update question
            else if(!empty($text)) {
           $poziadavka =  $db->posliPoziadavku("UPDATE Odpoved SET text_odpovede='$text', body='$body' WHERE id_odpovede = '$id'");
    }
    }
}
?><?php
