function showQuestions(){
    document.getElementById("timer").style.display = 'none';
    document.getElementById("answers").style.display = 'none';
    document.getElementById("startQuestions").innerHTML="Ukonči";


    // Show icons for start/stop and answers
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
    // Color start button to gray
    document.getElementById(xxx).style.color = "gray";
    document.getElementById(xxx).disabled = true;


    // Get question id
    id = xxx.split(" ");
    fullId1= "S ".concat(id[1]);
    fullId2= "A ".concat(id[1]);
    clicked_question_id = id[1];
    // Color other to button to green
    document.getElementById(fullId1).style.color = "#0A7E8F";
    document.getElementById(fullId2).style.color = "#0A7E8F";

    // Add selected question to test in database
    var test_id = document.getElementById('new_test_id').value;
    $.ajax({
        type: 'POST',
        url: 'createNewTest.php',
        data: 'test_id=' + test_id + '&clicked_question_id= ' + clicked_question_id,
        success: function (data) {
            alert("Otázka bola úspešne spustená");
        }
    });

}

function stopQuestion(xxx) {
    document.getElementById(xxx).style.color = "gray";
    let id = xxx.split(" ");
    let clicked_question = id[1];
    var test_id = document.getElementById('new_test_id').value;
    $.ajax({
        type: 'POST',
        url: 'stopNewTest.php',
        data: 'test_id=' + test_id + '&clicked_question_id= ' + clicked_question,
        success: function (data) {
            alert("Otázka bola úspešne ukončená");
        }
    });
}

function showResults(xxx) {
    console.log("Zobrazujem vysledky k otazke c. " + xxx);
}