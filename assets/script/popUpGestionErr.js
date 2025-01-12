// affichage des pop up
function showPopUp(message, success=true){
    let popUp = document.createElement("div");
    let texte = document.createElement("p");
    console.log(message);
    if(success){
        popUp.classList.add("succes");
    }
    else{
        popUp.classList.add("erreur");
    }
    texte.textContent = message;
    popUp.appendChild(texte);
    document.getElementsByTagName("body")[0].appendChild(popUp);
    setTimeout(() => {
        document.getElementsByTagName("body")[0].removeChild(popUp);
    }, 3000);
}