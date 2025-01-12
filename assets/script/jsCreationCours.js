// Appel initial pour synchroniser la valeur par défaut
document.addEventListener('DOMContentLoaded', () => {
    Combobox();
    Comboboxpersonne();
    comboboxduree();
    
});

function getDate(month,year){


let titres = document.querySelectorAll('.jourpossible');
let aujourdhui = document.querySelectorAll('.today');

titres.forEach((element) => {
    element.addEventListener("click", ()=> {

        let valeur =element.id;
        changerTexte(valeur,month,year);
        
    });
  });

aujourdhui.forEach((element) => {
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

function Comboboxpersonne()
{
    // Récupération des éléments
    const combobox = document.getElementById('comboboxpersonne');
    const inputField = document.getElementById('niveau');

    // Événement lorsque l'utilisateur sélectionne une option
    combobox.addEventListener('change', () => {
        // Mettre à jour la valeur de l'input avec la valeur sélectionnée
        inputField.value = combobox.value;
    });
}


function comboboxduree()
{
    // Récupération des éléments
    const combobox = document.getElementById('comboboxduree');
    const inputField = document.getElementById('choixheure');

    // Événement lorsque l'utilisateur sélectionne une option
    combobox.addEventListener('change', () => {
        // Mettre à jour la valeur de l'input avec la valeur sélectionnée
        inputField.value = combobox.value;
    });
}