
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