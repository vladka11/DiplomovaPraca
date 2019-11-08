<?php
session_start(); ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="navigationDesign.css">

</head>
<body>
<!-- The sidebar -->
<div class="wrapper">
    <div class="sidebar">
        <div class="sidebar-header">
            <a><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION["login"] ?></a>
        </div>
        <ul class="list-unstyled components">
            <li><a href="#home">Informatika 1</a></li>
            <li><a class="active" href="#news">Informatika 2</a></li>
            <li><a href="#contact">Operačné systémy</a></li>
            <li><a href="#about">Databázové systémy</a></li>
            <li><!-- Link with dropdown items -->
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">Webové aplikácie</a>
                <ul class="collapse list-unstyled" id="homeSubmenu">
                    <li><a href="#">Page</a></li>
                    <li><a href="#">Page</a></li>
                    <li><a href="#">Page</a></li>
                </ul>
    </div>

    <div class="sidebar2">
        <a href="#home">Home</a>
        <a class="active" href="#news">News</a>
        <a href="#contact">Contact</a>
        <a href="#about">About</a>
    </div>
</div>
<!-- Page content -->
<div class="content">
    ..
</div>
</body>