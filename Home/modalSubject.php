<!DOCTYPE html>
<html>
<body>
<!-- Modal -->
<div class="modal" id="modalSubject" role="dialog">
    <form method="post" action="addSubject.php">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <p id="titleModal"><span class="glyphicon glyphicon-plus-sign"></span>   Pridanie nového predmetu</p>
                    <button type="button" class="close" data-dismiss="modal" onclick="document.getElementById('modalSubject').style.display='none'; document.getElementById('emptyModal').style.display='none'" >&times;</button>
                </div>
                <div class="modal-body" style="padding:40px 40px;">
                    <form role="form">
                        <div class="form-group">
                            <label for="subject">Názov predmetu</label>
                            <input type="text" class="form-control" id="subject" name="subject" placeholder="Zadajte názov predmetu">
                        </div>
                        <div class="form-group">
                            <label for="year">Ročník výučby</label>
                            <input type="text" class="form-control" id="year" name="year" placeholder="Zadajte ročník vyučby predmetu">
                        </div>
                        <h5 id="emptySubjectModal"></h5>
                        <button type="submit" class="btn-block btnModal">Pridaj</button>
                    </form>
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>
