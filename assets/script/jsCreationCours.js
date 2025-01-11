

function getDate(month,year){
// Récupérer un élément par son ID
const titres = document.querySelectorAll('.jourpossible');

// Ajout d'un gestionnaire à chaque élément
titres.forEach((element) => {
    element.addEventListener("click", ()=> {

        let valeur =element.id;
        changerTexte(valeur,month,year);
        
    });
  });

}


function changerTexte(valeur,month,year) {
    month  = month < 10 ? '0' + month : month;
    valeur = valeur < 10 ? '0' + valeur : valeur;

    const dateselectionner = document.getElementById('montrerdate');
    dateselectionner.textContent = valeur+"/"+month+"/"+year;

    const dateimput = document.getElementById('datevalider');
    dateimput.value = year+"-"+month+"-"+valeur;

    console.log(dateimput.value);
    console.log(dateimput.valueAsNumber)

}



