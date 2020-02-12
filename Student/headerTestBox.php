<div class="row" id="enter_id_box">
                <div class="col-xs-12" id="ented_id_text">
                    <div class="col-xs-6 col-md-6"><input type="text" class="form-control" id="inputID" placeholder="Zadaj id prednášky"></div>
                    <div class="col-xs-6 col-md-6"><button type="submit" class="button" onclick="openTest()">Potvrd</button></div>
                </div>
</div>

<script>
    // TODO Check if test id exists, if not, display alert
    function openTest() {
        var inputID = document.getElementById('inputID').value;
        $.ajax({
            url: "fetchTestData.php",
            data: {"presentStudent": inputID, },
            type: "POST",
            success: function () {
                document.cookie = "inputID= " + inputID;
                window.location = "onlineTestQuestions.php";
            }
        });
        // document.cookie = "inputID= " + inputID;
        // window.location.replace("http://localhost:8080/DiplomovaPraca/Student/onlineTestQuestions.php");
    }
</script>