
function afficheCreerPoney(){
    document.getElementById('creerPoney').style.display = "flex";
}


function closeCreerPoney(){
    document.getElementById('creerPoney').style.display = "none";
}

function afficheCreerMoniteur(){
    document.getElementById('creerMoniteur').style.display = "flex";
}


function closeCreerMoniteur(){
    document.getElementById('creerMoniteur').style.display = "none";
}

function remplirPoney(nomPoney, poidMax, photo, race){
    document.getElementById("nomPoney").value = nomPoney;
    document.getElementById("poidMax").value = poidMax;
    document.getElementById("photo").value = photo;
    document.getElementById("race").value = race;
}

function remplirMoniteur(usernameMoniteur, prenomMoniteur, nomMoniteur, Mail,estAdmin,salaire){
    document.getElementById("usernameMoniteur").value = usernameMoniteur;
    document.getElementById("prenomMoniteur").value = prenomMoniteur;
    document.getElementById("nomMoniteur").value = nomMoniteur;
    document.getElementById("Mail").value = Mail;
    document.getElementById("estAdmin").value = estAdmin;
    document.getElementById("salaire").value = salaire;
}

document.addEventListener('click', function(event) {
    const creerPoneyDiv = document.getElementById('creerPoney');
    const creerMoniteurDiv = document.getElementById('creerMoniteur');

    if (!creerPoneyDiv.contains(event.target) && creerPoneyDiv.style.display === "flex") {
        closeCreerPoney();
    }
    if (!creerMoniteurDiv.contains(event.target) && creerMoniteurDiv.style.display === "flex") {
        closeCreerMoniteur();
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