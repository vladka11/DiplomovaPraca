<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        .modal-header, h4, .close {
            background-color: #34B8C0;
            color:white !important;
            text-align: center;
            font-size: 30px;
        }
        .btn {
            background-color: #34B8C0;
            color: white;
            display: block;
        }
        .btn:hover{
            color: white;
            background-color: #0A7E8F;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Trigger the modal with a button -->
    <button type="button" class="btn btn-default btn-lg" id="myBtn">Login</button>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:35px 50px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span class="glyphicon glyphicon-plus-sign"></span> Pridanie novej témy</h4>
                </div>
                <div class="modal-body" style="padding:40px 50px;">
                    <form role="form">
                        <div class="form-group">
                            <label for="usrname"><span class="glyphicon glyphicon-user"></span> Názov temy</label>
                            <input type="text" class="form-control" id="topic" placeholder="Zadajte názov temy">
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Pridaj</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#myBtn").click(function(){
            $("#myModal").modal();
        });
    });
</script>

</body>
</html>
