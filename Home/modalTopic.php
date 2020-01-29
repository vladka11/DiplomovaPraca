<?php
$logged_id = $_SESSION["userid"];
$query = "SELECT * FROM Predmet JOIN Vyucuje USING (id_predmetu) WHERE id_ucitela = '$logged_id '";
$db = new database();
$db->pripoj();
$result = $db->posliPoziadavku($query);
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>
<body>
    <!-- Modal -->
    <div class="modal" id="myModal" role="dialog">
        <form method="post" action="addTopic.php">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <p id="titleModal"><span class="glyphicon glyphicon-plus-sign"></span>   Pridanie novej témy</p>
                    <button type="button" class="close" data-dismiss="modal" onclick="document.getElementById('myModal').style.display='none'; document.getElementById('emptyModal').style.display='none'" >&times;</button>
                </div>
                <div class="modal-body" style="padding:40px 40px;">
                    <form role="form">
                        <label>Názov predmetu</label>
                        <!-- School dropdown -->
                        <div class="form-group">
                            <select class="form-control" id="predmetSelect" name="predmetSelect">
                                <?php
                                if($result->num_rows > 0){
                                    while($row = $result->fetch_assoc()){
                                        echo '<option type="text" class="form-control" value="'.$row['id_predmetu'].'">'.$row['nazov_predmetu'].'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="usrname">Názov temy</label>
                            <input type="text" class="form-control" id="topic" name="topic" placeholder="Zadajte názov temy">
                        </div>
                        <h5 id="emptyModal"></h5>
                        <button type="submit" class="btn-block btnModal">Pridaj</button>
                    </form>
                </div>
            </div>
        </div>
        </form>
    </div>
</body>
</html>
