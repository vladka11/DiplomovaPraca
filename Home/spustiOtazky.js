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