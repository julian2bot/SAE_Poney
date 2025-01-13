function getDate(event,month,year){
    const element = event.target;

    console.log("yes");
    

    let valeur =element.id;
    changerTexte(valeur,month,year);
        
};

function changerTexte(valeur,month,year) {
    month  = month < 10 ? '0' + month : month;
    valeur = valeur < 10 ? '0' + valeur : valeur;

    const dateselectionner = document.getElementById('montrerdate');
    dateselectionner.textContent = valeur+"/"+month+"/"+year;

    const dateimput = document.getElementById('datevalider');
    dateimput.value = year+"-"+month+"-"+valeur;

    console.log(dateimput.value);
    console.log(dateimput.valueAsNumber);

    let selected = document.getElementsByClassName("selected")[0];
    if(selected){
        selected.classList.remove("selected");
    }
    document.getElementById(valeur).classList.add("selected");
}
