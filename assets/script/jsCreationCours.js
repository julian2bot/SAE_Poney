
if (document.getElementById('date') === null){
  console.log("erreur de chargement");
}
else{
  let element = document.getElementById('date');
  element.addEventListener('change', event => {
  textInput.value = event.target.value;
  event.target.value = '';
  });
}

function caseCliquer(){
  // Sélectionner tous les boutons avec la classe "btn"
  let casepossible = document.querySelectorAll("cellule");
// Ajouter un gestionnaire d'événement "click" pour chaque bouton
casepossible.forEach((td) => {
    td.addEventListener("click", (event) => {
      
        // Récupérer l'identifiant du bouton cliqué
        const boutonId = event.target.id;

        alert(boutonId);

    });
});

}

function decrementerdate() {
  alert("-1");
}

function incrementerdate() {
  alert("+1");
}

