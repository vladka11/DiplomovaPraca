function showQuestions(){
    document.getElementById("timer").style.display = 'none';
    document.getElementById("answers").style.display = 'none';
    document.getElementById("startQuestions").innerHTML="Ukonči";


    //zobrazenie ikoniek na spustenie/zastavenie otazky a zobrazenie vysledokv
    elements = document.getElementsByClassName("start");
    for (var i = 0; i < elements.length; i++) {
        elements[i].firstChild.style.display='block';
    }

    elements2 = document.getElementsByClassName("stop");
    for (var i = 0; i < elements2.length; i++) {
        elements2[i].firstChild.style.display='block';
    }

    elements3 = document.getElementsByClassName("actualAnswers");
    for (var i = 0; i < elements3.length; i++) {
        elements3[i].firstChild.style.display='block';
    }

}

function startQuestion(xxx) {
    console.log("Spustam otazku c. " + xxx);

    //Zafarbenie start buttonu na šedo
    document.getElementById(xxx).style.color = "gray";

    //Ziskanie id otazky
    id = xxx.split(" ");
    fullId1= "S ".concat(id[1]);
    fullId2= "A ".concat(id[1]);
    clicked_question_id = id[1];
    //prefarbenie buttonov ukonču a vysledky na aktívnu zelenu
    document.getElementById(fullId1).style.color = "#0A7E8F";
    document.getElementById(fullId2).style.color = "#0A7E8F";

    //Pridanie otázky k testu
    var test_id = document.getElementById('new_test_id').value;
    $.ajax({
        type: 'POST',
        url: 'createNewTest.php',
        data: 'test_id=' + test_id + '&clicked_question_id= ' + clicked_question_id,
        success: function (data) {
            alert("Otázka bola úspešne pridaná");
        }
    });

}

function stopQuestion(xxx) {
    console.log("Ukoncujem otazku c. " + xxx);
    document.getElementById(xxx).style.color = "gray";

}

function showResults(xxx) {
    console.log("Zobrazujem vysledky k otazke c. " + xxx);
}