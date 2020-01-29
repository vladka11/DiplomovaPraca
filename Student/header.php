<?php
session_start();
$user_id = $_SESSION["userid"];
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="studentDesign.css?version=11">

</head>
<body>
<nav class="navbar">
    <div class="header">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <h1 id="user_icon"><span class="glyphicon glyphicon-user"></span></h1>
                <div id="header_text">
                    <div class="row">
                        <div class="col-xs-12 col-md-12" id="user_name" style="font-weight: 600"></div>
                        <div class="col-xs-12 col-md-12"><span class="glyphicon glyphicon glyphicon-bookmark"> <span id="specialization"></span></span>
                        </div>
                        <div class="col-xs-12 col-md-12"><span class="glyphicon glyphicon-education"> <span id="group"></span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
    <div class="row" id="enter_id_box">
                <div class="col-xs-12" id="ented_id_text">
                    <div class="col-xs-6 col-md-6"><input type="text" class="form-control" id="inputID" placeholder="Zadaj id prednášky"></div>
                    <div class="col-xs-6 col-md-6"><button type="submit" class="button">Potvrd</button></div>
                </div>
        </div>
</body>

<script>
    $(document).ready(function () {
            $.ajax({
                url: "fetchUserData.php",
                method: "POST",
                data: {user_data: "data"},
                dataType: "json",
                success: function (data) {
                    document.getElementById("user_name").innerHTML= data.meno + " " + data.priezvisko;
                    document.getElementById("specialization").innerHTML= data.nazov_odboru;
                    document.getElementById("group").innerHTML= data.kruzok;

                }

            });
        })

</script>