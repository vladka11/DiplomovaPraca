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
    <link href="modalDesign.css?version2" rel="stylesheet" type="text/css"/>
    <div class="modal" id="myModal" role="dialog">
        <form method="post" action="addTopic.php">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:15px 30px;">
                    <button type="button" class="close" data-dismiss="modal" onclick="document.getElementById('myModal').style.display='none'" >&times;</button>
                    <p id="titleModal"><span class="glyphicon glyphicon-plus-sign"></span> Pridanie novej témy</p>
                </div>
                <div class="modal-body" style="padding:40px 40px;">
                    <form role="form">
                        <div class="form-group">
                            <label for="usrname"><span class="glyphicon glyphicon-user"></span> Názov temy</label>
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
