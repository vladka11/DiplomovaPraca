<?php

include("../database.php");
$db = new database();
$db->pripoj();


// Fetch all the schools
$query = "SELECT * FROM Skola";
$result = $db->posliPoziadavku($query);
?>

<!DOCTYPE html>
<lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="registrationDesign.css?version=1">
</head>
<body>
<div class="container">
    <h1 align="center"><span class="glyphicon glyphicon-user"></span> Registrácia zamestnanca</h1>
    <div class="panel panel-default text-center"  style="border: solid #0c5460;">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">

                <?php /** echo $result; */?>

                <form method="post" role="form" action="teacherRegistration.php">
                    <h6 id="sprava" style="color: red;"> </h6>
                    <legend>Prihlasovacie údaje</legend>
                    <div class="form-group">
                        <input type="text" name="login" class="form-control" placeholder="Prihlasovacie meno">
                    </div>

                    <div class="form-group">
                        <input type="password" name ="heslo" class="form-control" placeholder="Heslo">
                    </div>

                    <legend>Osobné údaje</legend>
                    <div class="form-group">
                        <input type="text" name ="meno" class="form-control" placeholder="Krstné meno">
                    </div>

                    <div class="form-group ">
                        <input type="text" name ="priezvisko" class="form-control" placeholder="Priezvisko">
                    </div>

                    <div class="form-group">
                        <input type="email" name ="email" class="form-control" placeholder="E-mail">
                    </div>

                    <legend>Údaje o škole</legend>
                    <!-- School dropdown -->
                    <div class="form-group">
                        <select class="form-control" id="school">
                            <option value="">Vyber školu</option>
                            <?php
                            if($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo '<option type="text" class="form-control" value="'.$row['id_skoly'].'">'.$row['nazov_skoly'].'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <!-- State dropdown -->
                    <div class="form-group">
                        <select class="form-control" id="faculty" name="fakulta">
                            <option value="">Vyber fakultu</option>
                        </select>
                    </div>


                    <!-- City dropdown -->
                    <div class="form-group">
                        <select class="form-control" id="katedra" name="katedra">
                            <option value="">Vyber katedru</option>
                        </select>
                    </div>
                    <h6 id="error-message"></h6>
                    <div align="center">
                        <button formmethod="post" type="submit" name="submit" class="btn btn-secondary" value="Registruj ma">Registracia</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>

<script type="text/javascript">
    $(document).ready(function(){
        $('#school').on('change', function(){
            var countryID = $(this).val();
            if(countryID){
                $.ajax({
                    type:'POST',
                    url:'ajaxSelectBoxData.php',
                    data:'country_id='+countryID,
                    success:function(html){
                        $('#faculty').html(html);
                        $('#katedra').html('<option value="">Vyber najskôr fakultu</option>');
                    }
                });
            }else{
                $('#fakulta').html('<option value="">Vyber najskôr školu</option>');
                $('#katedra').html('<option value="">Vyber najskôr fakultu</option>');
            }
        });

        $('#faculty').on('change', function(){
            var stateID = $(this).val();
            if(stateID){
                $.ajax({
                    type:'POST',
                    url:'ajaxSelectBoxData.php',
                    data:'faculty_id='+stateID,
                    success:function(html){
                        $('#katedra').html(html);
                    }
                });
            }else{
                $('#odborID').html('<option value="">Vyber najskôr fakultu</option>');
            }
        });
    });
</script>
</html>