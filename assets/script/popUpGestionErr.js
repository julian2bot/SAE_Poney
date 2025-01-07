function popUpErreur(){
    document.getElementById("errReservCours").style.display= "flex";
    setTimeout(() => {
        clearPopUpErreur();
    }, 3000);
}

function clearPopUpErreur(){
    document.getElementById("errReservCours").style.display= "none";
}

function popUpSucces(){
    document.getElementById("succesEditMoniteur").style.display= "flex";
    setTimeout(() => {
        clearPopUpSucces();
    }, 3000);
}

function clearPopUpSucces(){
    document.getElementById("succesEditMoniteur").style.display= "none";
}

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