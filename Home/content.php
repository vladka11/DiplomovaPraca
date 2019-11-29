<?php
include("navigationBar.php");
$predmetAtema= (explode("x",$_COOKIE["predmetTema"]));
if ($predmetAtema==" "){
    $predmetAtema="Nazov predmetu x Nazov temy";
}
$id_predmetu= (int)$predmetAtema[0];
$id_temy= (int)$predmetAtema[1];
global $nazov_temy;
global $nazov_predmetu;
$nazovTema=$db->posliPoziadavku("SELECT nazov_temy, nazov_predmetu FROM Tema JOIN Predmet ON Tema.id_predmetu=Predmet.id_predmetu WHERE Tema.id_temy='$id_predmetu' AND Predmet.id_predmetu = '$id_temy'");
$numrows = mysqli_num_rows($nazovTema);
if ($numrows!= 0) {
    while ($row = mysqli_fetch_assoc($nazovTema)) {
        $nazov_temy = $row['nazov_temy'];
        $nazov_predmetu = $row['nazov_predmetu'];
    }
}
?>
<!-- Page Content Holder -->
<div id="content"">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button type="button" id="sidebarCollapse" class="navbar-btn">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <h4 id="nazovTemy"> <?php echo $nazov_predmetu ?>  :  <?php echo $nazov_temy ?></h4>
    </nav>
<div class="container">
    <h3> Učebné materiály </h3>
    <hr>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>


    <h3>Priradené otázky</h3>
    <hr>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>


    <h3><span class="glyphicon glyphicon-play-circle"></span>  Spustenie testu</h3>
    <hr>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
</div>
</div>

</div>

