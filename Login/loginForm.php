<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="loginDesign.css?version=1">

</head>
<body>

    <div class="container">
        <div class="panel panel-default text-center"  style="border: solid #0c5460;">
            <div class="row">
        <div class="col-sm-6 col-xs-12"  style="border:lightgrey; border-right-style: solid" >
                <div class="panel-heading">
                    Prihlásenie
                </div>
                <div class="panel-body text-center" >

                    <form class="form-horizontal"  method="post" role="form" action="login.php">

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="email">Login:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="email" placeholder="Zadaj prihlasovacie meno" name="email">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="pwd">Heslo:</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="pwd" placeholder="Zadaj heslo" name="pwd">
                            </div>
                        </div>
                        <div id="radioButtons">
                            <label class="radio-inline">
                                <input type="radio" name="optradio" value="student" checked>Študent
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="optradio" value="ucitel" id="ucitelRadio">Učiteľ
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="optradio" value="admin">Admin
                            </label>
                            </div>
                        <p></p>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default" id="loginButton">Prihlásenie</button>
                            </div>
                        </div>
                        <h6 id="error-message"></h6>
                        <div class="form-group text-right">
                            <p>Ešte nemáte vytvorený účet? </p>
                            <div class="row">
                                <div class="col-sm-6" id="registrationTeacher"><p style="color: #0c5460; font-weight: bold" onclick="document.location.href='../Registration/registrationFormTeacher.php'"> Registrácia zamestnanca </p></div>
                               <div class="col-sm-6" id="registrationStudent"><p style="color: #0c5460; font-weight: bold" onclick="document.location.href='../Registration/registrationFormStudent.php'"> Registrácia študenta </p></div>
                            </div>
                        </div>
                    </form>

                </div>
        </div>
        <div class="col-sm-6 col-xs-12">
                <div class="panel-body">
                    <img src="logoof.png" alt="University of Economics logo"  width="50%" height="50%">
                    <div class="row" >
                        <div class="col-sm-6">Developed by: Vladislava Kopálová </div>
                        <div class="col-sm-6">Led by: Ing. Jaroslav Kultan, PhD.</div>
                    </div>

                     </div>
                    </div>
                    </div>
                </div>
            </div>
    </div>
        </div>
    </div>
</body>