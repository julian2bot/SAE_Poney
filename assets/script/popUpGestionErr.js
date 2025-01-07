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