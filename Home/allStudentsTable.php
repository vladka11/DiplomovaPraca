<?php
if (session_id() == '') {
    session_start();
}
$headerTitle = "Zobrazenie všetkých študentov";
$logged_id = $_SESSION["userid"];
include("./offlineNavigationBar.php");
include("./header.php");

$all_questions = $db->posliPoziadavku("SELECT * FROM Student 
                                                  JOIN Studuje USING (id_studenta) 
                                                  JOIN Predmet USING (id_predmetu) 
                                                  JOIN Vyucuje USING (id_predmetu) 
                                                  WHERE id_ucitela = '$logged_id'
                                                  ORDER BY nazov_predmetu, priezvisko");

?>
<html lang="en">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="table.css?version13" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="container">
    <input type="text" id="studentInput" onkeyup="searchStudent()" placeholder="Zadaj priezvisko študenta">
    <div class="table-responsive">
        <div id="employee_table" style="overflow-x:auto;">
            <table class="table table-bordered" id="all_students_table">
                <tr>
                    <th style="width: 30% !important;">Názov predmetu</th>
                    <th style="width: 10% !important;">ID študenta</th>
                    <th>Meno</th>
                    <th>Priezvisko</th>
                    <th>Krúžok</th>
                    <th>Body</th>
                    <th>Zobraziť</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($all_questions)) {
                    ?>
                    <tr>
                        <td><?php echo $row["nazov_predmetu"]; ?></td>
                        <td><?php echo $row["id_studenta"]; ?></td>
                        <td><?php echo $row["meno"]; ?></td>
                        <td><?php echo $row["priezvisko"]; ?></td>
                        <td><?php echo $row["kruzok"]; ?></td>
                        <td><?php echo $row["hodnotenie"]; ?></td>
                        <td><span class='glyphicon glyphicon glyphicon-list-alt show_data' data-sbjct=<?php echo $row["id_predmetu"]; ?> "
                                  id='<?php echo $row["id_studenta"]; ?> '></span></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
</div>

<!-- Show students grade modal -->
<div id="dataModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Employee Details</h4>
            </div>
            <div class="modal-body" id="employee_detail">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="show_grades_modal" class="modal fade">
    <!-- Modal Content -->
    <form class="modal-content animate" id="insert_form">
        <div class="container">
            <div class="form-group">
                <div class="modal-body">
                    <div>

                <!-- Tests -->
                        <div style="overflow-x:auto;">
                            <table class="table table-bordered" id="all_tests_table">
                                <tr>
                                    <th>Id testu</th>
                                    <th>Dátum testu</th>
                                    <th>Téma</th>
                                    <th>Počet bodov</th>
                                    <th>Max počet bodov</th>
                                </tr>
                            </table>
                        </div>

                    <div class="row">
                        <button id="save_button" type="submit" name="insert" data-dismiss="modal">Zavriet</button>
                        <!--<button type="button" data-dismiss="modal">Close</button>-->
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


<script>
    $(document).ready(function () {
        $(document).on('click', '.show_data', function () {
            var student_id = $(this).attr("id");
            var subject_id = $(this).attr("data-sbjct");
            $.ajax({
                type: 'POST',
                url: 'fetchStudentTestData.php',
                data: 'student_id=' + student_id + '&subject_id=' + subject_id,
                dataType: "json",
                success: function (data) {
                    if(data == '0'){
                        alert("Študent nemá žiadne vyplnené testy z daného predmetu");
                    } else{
                        $("#all_tests_table").find("tr:gt(0)").remove();
                        for(var i in data) {
                            var Row = data[i];
                            $('#all_tests_table').append('<tr><td> ' + Row.id_testu + '</td>' +
                                '                             <td> ' + Row.datum_testu + '</td>' +
                                '                             <td> ' + Row.nazov_temy+ '</td>' +
                                '                             <td> ' + Row.pocet_bodov + '</td>' +
                                '                             <td> ' + Row.max_body + '</td></tr>');

                        }
                        $('#show_grades_modal').modal('show');
                    }
                }
                });
            });
        });

    function searchStudent() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("studentInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("all_students_table");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[3];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
</body>
</html>