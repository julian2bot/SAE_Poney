function popUpErreur(){
    document.getElementById("errReservCours").style.display= "flex";
    setTimeout(() => {
        clearPopUpErreur();
    }, 3000);
}

function clearPopUpErreur(){
    document.getElementById("errReservCours").style.display= "none";
}