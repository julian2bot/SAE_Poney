
function afficheCreerPoney(){
    document.getElementById('creerPoney').style.display = "flex";
}


function closeCreerPoney(){
    document.getElementById('creerPoney').style.display = "none";
}


document.addEventListener('click', function(event) {
    const creerPoneyDiv = document.getElementById('creerPoney');

    if (!creerPoneyDiv.contains(event.target) && creerPoneyDiv.style.display === "flex") {
        closeCreerPoney();
    }
});

document.getElementById("creation_poney").addEventListener('click',function(event){
    event.preventDefault(); 
    event.stopPropagation();  // Empêche la propagation du clic vers l'écouteur global
    afficheCreerPoney();
});