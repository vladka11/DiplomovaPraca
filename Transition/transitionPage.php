<?php
include "header.php";
?>

<div class="content">
    <div class="panel panel-default">
            <button class="button1"  id="button1" onclick="onlineRezim()"> <p class="glyphicon glyphicon-menu-left" style="padding: 2%" ></p>Online režim</button>
            <button class="button2" id="button2" onclick="offlineRezim()">Offline režim<p class="glyphicon glyphicon-menu-right" style="padding: 2%"></p></button>
    </div>
</div>

<script>
    function onlineRezim() {
        window.location = "../Home/onlineContent.php";
    }

    function offlineRezim() {
        window.location = "../Home/offlineContent.php";
    }
</script>