<?php
include "./header.php";
include "./headerTestBox.php";
?>
<div id="content">
    <div id="box_items" style="padding-left:15%; padding-top: 8%">
    <div class="row" id="boxes" style="padding-bottom: 15px">
        <div class="column" style="background-color:#5297A7; " onclick="openSubjects()">
            <h2><span class="glyphicon glyphicon-list-alt"></span></h2>
            <p>Predmety</p>
        </div>
        <div class="column" style="background-color:#6F90A4; margin-left:15px" onclick="openGrades()">
            <h2><span class="glyphicon glyphicon-education"></span></h2>
            <p>Známky</p>
        </div>
    </div>

    <div class="row" id="boxes">
        <div class="column" style="background-color:#6F90A4;">
            <h2><span class="glyphicon glyphicon-log-out"></span></h2>
            <p>Odhlásenie</p>
        </div>
        <div class="column" style="background-color:#2BA7AF; margin-left:15px">
            <h2>Item 4</h2>
            <p>Text..</p>
        </div>
    </div>
</div>
</div>
<script>
    function openSubjects() {
        window.location = "allStudentsSubjects.php";
    }

    function openGrades(){
        window.location = "allGradesList.php";
    }

</script>

