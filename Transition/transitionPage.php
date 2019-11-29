<?php
include "header.php";
?>

<div class="content">
    <div class="panel panel-default">
        <div class="panel-body" style="background-color: #6F90A4; text-align: left" onclick="offlineRezim()">
            <p class="glyphicon glyphicon-menu-left" style="padding: 2%"></p>Offline režim
        </div>
        <div class="panel-body" style="background-color: #34B8C0; text-align: right">Online režim
            <p class="glyphicon glyphicon-menu-right" style="padding: 2%"></p>
        </div>
    </div>
</div>

<script>
    function offlineRezim() {
        window.location = "../Home/content.php";
    }
</script>