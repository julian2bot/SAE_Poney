function focusDivFlex(){
    document.body.style.overflow = "hidden"; 
    document.getElementById('flou').style.filter = "blur(1px)"; 
    
    let listes = document.getElementsByClassName("list");

    for (let liste of listes) {
        liste.style.overflow = "hidden";
    }

}

function reversefocusDivFlex(){
    document.body.style.overflow = "auto"; 
    document.getElementById('flou').style.filter = "blur(0px)"; 
    let listes = document.getElementsByClassName("list");

    for (let liste of listes) {
        liste.style.overflow = "auto";
    }
}


//  dans la page d'administration affiché / retirer les pop Up pour edit / creer des poneys ou moniteur
function afficheCreerPoney(){
    document.getElementById('creerPoney').style.display = "flex";
    focusDivFlex();
}

function closeCreerPoney(){
    document.getElementById('creerPoney').style.display = "none";
    reversefocusDivFlex();
}

function afficheCreerMoniteur(){
    document.getElementById('creerMoniteur').style.display = "flex";
    focusDivFlex();
}


function closeCreerMoniteur(){
    document.getElementById('creerMoniteur').style.display = "none";
    reversefocusDivFlex();
}



function afficheModifPoney(){
    document.getElementById('modifierPoney').style.display = "flex";
    focusDivFlex()
}

function closeModifPoney(){
    document.getElementById('modifierPoney').style.display = "none";
    reversefocusDivFlex();
}

function afficheModifMoniteur(){
    document.getElementById('modifierMoniteur').style.display = "flex";
    focusDivFlex()
}


function closeModifMoniteur(){
    document.getElementById('modifierMoniteur').style.display = "none";
    reversefocusDivFlex();
}

function remplirPoney(nomPoney, poidMax, photo, race){
    let div = document.getElementById("creerPoney");
    div.getElementsByClassName("nomPoney")[0].value = nomPoney;
    div.getElementsByClassName("poidMax")[0].value = poidMax;
    div.getElementsByClassName("photo")[0].value = photo;
    div.getElementsByClassName("race")[0].value = race;
    afficheCreerPoney();
}

function remplirPoneyModif(identifiant, nomPoney, poidMax, photo, race){
    let div = document.getElementById("modifierPoney");
    div.getElementsByClassName("identifiant")[0].value = identifiant;
    div.getElementsByClassName("nomPoney")[0].value = nomPoney;
    div.getElementsByClassName("poidMax")[0].value = poidMax;
    div.getElementsByClassName("photo")[0].value = photo;
    div.getElementsByClassName("race")[0].value = race;
    afficheModifPoney();
}

function remplirMoniteur(usernameMoniteur, prenomMoniteur, nomMoniteur, Mail,estAdmin,salaire){
    let div = document.getElementById("creerMoniteur");
    div.getElementsByClassName("usernameMoniteur")[0].value = usernameMoniteur;
    div.getElementsByClassName("prenomMoniteur")[0].value = prenomMoniteur;
    div.getElementsByClassName("nomMoniteur")[0].value = nomMoniteur;
    div.getElementsByClassName("Mail")[0].value = Mail;
    div.getElementsByClassName("estAdmin")[0].value = estAdmin;
    div.getElementsByClassName("salaire")[0].value = salaire;
    afficheCreerMoniteur();
}

function remplirMoniteurModif(ancienUsernameMoniteur,ancienMail, usernameMoniteur, prenomMoniteur, nomMoniteur, Mail,estAdmin,salaire){
    let div = document.getElementById("modifierMoniteur");
    div.getElementsByClassName("identifiant")[0].value = ancienUsernameMoniteur;
    div.getElementsByClassName("usernameMoniteur")[0].value = usernameMoniteur;
    div.getElementsByClassName("prenomMoniteur")[0].value = prenomMoniteur;
    div.getElementsByClassName("nomMoniteur")[0].value = nomMoniteur;
    div.getElementsByClassName("Mail")[0].value = Mail;
    div.getElementsByClassName("ancienMail")[0].value = ancienMail;
    div.getElementsByClassName("estAdmin")[0].value = estAdmin;
    div.getElementsByClassName("salaire")[0].value = salaire;
    afficheModifMoniteur();
}

function pasDansBoutons(event){
    let lesButtons = document.getElementsByTagName("button");
    for (const element of lesButtons) {
        if(element.contains(event.target)){
            return false;
        }
    }
    return true;
}

document.addEventListener('click', function(event) {
    const creerPoneyDiv = document.getElementById('creerPoney');
    const creerMoniteurDiv = document.getElementById('creerMoniteur');
    const modifPoneyDiv = document.getElementById('modifierPoney');
    const modifMoniteurDiv = document.getElementById('modifierMoniteur');

    if (!creerPoneyDiv.contains(event.target) && creerPoneyDiv.style.display === "flex") {
        if(pasDansBoutons(event)){
            closeCreerPoney();
        }

    }
    if (!creerMoniteurDiv.contains(event.target) && creerMoniteurDiv.style.display === "flex") {
        if(pasDansBoutons(event)){
            closeCreerMoniteur();
        }
    }
    if (!modifMoniteurDiv.contains(event.target) && modifMoniteurDiv.style.display === "flex") {
        if(pasDansBoutons(event)){
            closeModifMoniteur();
        }
    }
    if (!modifPoneyDiv.contains(event.target) && modifPoneyDiv.style.display === "flex") {
        if(pasDansBoutons(event)){
            closeModifPoney();
        }
    }

});

document.getElementById("creation_poney").addEventListener('click',function(event){
    closeCreerMoniteur();

    event.preventDefault(); 
    event.stopPropagation();  // Empêche la propagation du clic vers l'écouteur global
    afficheCreerPoney();
});



document.getElementById("creation_moniteur").addEventListener('click',function(event){
    closeCreerPoney();

    event.preventDefault(); 
    event.stopPropagation();  // Empêche la propagation du clic vers l'écouteur global
    afficheCreerMoniteur();
});