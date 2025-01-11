// Appel initial pour synchroniser la valeur par défaut
document.addEventListener('DOMContentLoaded', () => {
    Combobox();
});

function getDate(month,year){


const titres = document.querySelectorAll('.jourpossible');

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

function Combobox()
{
    // Récupération des éléments
    const combobox = document.getElementById('combobox');
    const inputField = document.getElementById('niveau');

    // Événement lorsque l'utilisateur sélectionne une option
    combobox.addEventListener('change', () => {
        // Mettre à jour la valeur de l'input avec la valeur sélectionnée
        inputField.value = combobox.value;
    });
}

