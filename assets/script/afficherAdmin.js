let abortControllerPoney = null;


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

function afficheCalendrierPoney(idPoney){
    document.getElementById('calendrierPoney').style.display = "block";
    focusDivFlex();
    
    const currentDate = new Date();
    createCalendarPoney(currentDate.getMonth(), currentDate.getFullYear(), idPoney);

        
    currentMonth = currentDate.getMonth();
    currentYear = currentDate.getFullYear();

    document.getElementById("prev-month").addEventListener("click", function() {
        if (abortControllerPoney) abortControllerPoney.abort();
        if (abortControllerPoney) abortControllerPoney.abort();

        if (currentMonth === 0) {
            currentMonth = 11; // Décembre
            currentYear--;
        } else {
            currentMonth--;
        }
        createCalendarPoney(currentMonth, currentYear, idPoney);
    });

    document.getElementById("next-month").addEventListener("click", function() {
        if (abortControllerPoney) abortControllerPoney.abort();
        if (abortControllerPoney) abortControllerPoney.abort();

        if (currentMonth === 11) {
            currentMonth = 0; // Janvier
            currentYear++;
        } else {
            currentMonth++;
        }
        createCalendarPoney(currentMonth, currentYear, idPoney);
    });


}

function closeCalendrierPoney(){
    document.getElementById('calendrierPoney').style.display = "none";
    reversefocusDivFlex();
    const calendrier = document.getElementById("calendrier");
    // console.log(calendrier.innerHTML)

    calendrier.innerHTML = " ";
    // console.log(calendrier.innerHTML)
    
    // TODO POUR FAIRE MIEUX ET REGL2 LE BUG (pour l'instant ca tiens au rilsan mdr) 
    window.location.href = '';
}


function remplirPoney(nomPoney, poidMax, photo, race){
    let div = document.getElementById("creerPoney");
    div.getElementsByClassName("nomPoney")[0].value = nomPoney;
    div.getElementsByClassName("poidMax")[0].value = poidMax;
    div.getElementsByClassName("preview")[0].src = photo;
    
    let preview = div.getElementsByClassName("preview")[0];

    let currentSrc = preview.src.split('/').pop(); // Extrait juste le nom du fichier actuel (sans chemin)

    preview.src = "../../assets/images/poney/" + photo;

    preview.style.display = 'block';
    div.getElementsByClassName("race")[0].value = race;
    afficheCreerPoney();
}

function remplirPoneyModif(identifiant, nomPoney, poidMax, photo, race){
    let div = document.getElementById("modifierPoney");
    div.getElementsByClassName("identifiant")[0].value = identifiant;
    div.getElementsByClassName("nomPoney")[0].value = nomPoney;
    div.getElementsByClassName("poidMax")[0].value = poidMax;
    // div.getElementsByClassName("preview")[0].src = photo;
    // console.log(div.getElementsByClassName("preview")[0].src)
    // div.getElementsByClassName("preview")[0].src = "../../assets/images/poney/"+div.getElementsByClassName("preview")[0].src+ photo;
    // div.getElementsByClassName("preview")[0].style.display = '';


    let preview = div.getElementsByClassName("preview")[0];

    let currentSrc = preview.src.split('/').pop(); // Extrait juste le nom du fichier actuel (sans chemin)

    preview.src = "../../assets/images/poney/" + photo;

    preview.style.display = 'block';

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
    const calendrierPoneyDiv = document.getElementById('calendrierPoney');

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

    if (!calendrierPoneyDiv.contains(event.target) && calendrierPoneyDiv.style.display !== "none") {
        if(pasDansBoutons(event)){
            closeCalendrierPoney();
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





function getDaysInMonth(month, year){
    return new Date(year, month, 0).getDate();
}


function getMonthName(month) {
    const monthNames = [
        "Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
        "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"
    ];
    return monthNames[month];
}


function addFloatTimes(startTime, endTime) {
    console.log(startTime, endTime, startTime + endTime)
    const totalTime = parseFloat(startTime) + parseFloat(endTime); // Additionner les heures en float
    console.log(totalTime)
    return convertFloatToTime(totalTime); // Convertir le résultat en h:mm
}

function convertFloatToTime(floatTime) {
    // Extraire les heures
    const hours = Math.floor(floatTime);

    // Calculer les minutes
    const minutes = Math.round((floatTime - hours) * 60);

    // Retourner au format h:mm
    return `${hours}h${minutes.toString().padStart(2, '0')}`;
}


function requestPoneyCours(year, month, day) {
    if (abortControllerPoney) {
        abortControllerPoney.abort();
    }
    // Créer un nouveau contrôleur pour la nouvelle requête
    abortControllerPoney = new AbortController();

    const signal = abortControllerPoney.signal;

    
    const xhr = new XMLHttpRequest();
    // Configurer la requête GET
    xhr.open('GET', `../utils/client/getter/getCoursByDateEntiere.php?date=${year+'-'+month+'-'+day}`, true);
    
    // Définir une fonction de callback pour gérer la réponse
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Manipuler les données de la réponse (par exemple, afficher les résultats)
            const response = JSON.parse(xhr.responseText);

            const lesInfos = document.getElementById("infoCours"); 

            while (lesInfos.firstChild) {
                lesInfos.removeChild(lesInfos.firstChild);
            }
            let dateDuCours = document.createElement("p");
            if(response[0]){
                
                dateDuCours.innerHTML = response[0].dateCours;
                lesInfos.appendChild(dateDuCours);
            }else{
                dateDuCours.innerHTML = "Pas de cours";
                lesInfos.appendChild(dateDuCours);

            }
            
            response.forEach(unCours => {

                let divInfo = document.createElement("div");
                divInfo.classList.add("infoDivCours");

                let heureDebutCours = document.createElement("p");
                let nomCoursP = document.createElement("p");
                heureDebutCours.innerHTML = convertFloatToTime(unCours.heureDebutCours) +' - '+ addFloatTimes(unCours.heureDebutCours, unCours.duree); 
                // heureDebutCours.innerHTML = unCours.heureDebutCours +' - '+ (unCours.heureDebutCours + unCours.duree); 
                nomCoursP.innerHTML = unCours.nomCours ? unCours.nomCours : "Cours poney"; 
                divInfo.appendChild(heureDebutCours); 
                lesInfos.appendChild(divInfo);

                
                divInfo.appendChild(nomCoursP);
                
                divInfo.addEventListener("click", function() {
                    // alert(`Vous avez cliqué sur le cours id ${unCours.idCours}, date ${unCours.dateCours} heure ${unCours.heureDebutCours}`);
                    location.href = `./reserverCours.php?idcours=${unCours.idCours}&dateCours=${unCours.dateCours}&heureCours=${unCours.heureDebutCours}`
                });


            });

        }
    };
    
    // Envoyer la requête
    xhr.send();

    
}






function getCoursPoneyByDate(date, idPoney) {
    if (abortControllerPoney) {
        abortControllerPoney.abort();
    }

    // Créer un nouveau contrôleur
    abortControllerPoney = new AbortController();
    const signal = abortControllerPoney.signal;

    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        
        // Configurer la requête GET
        if((date.getMonth() + 1)<10){
            xhr.open('GET', `../utils/poney/getter/getCoursByDatePoney.php?year=${date.getFullYear()}&month=0${date.getMonth() + 1}&idPoney=${idPoney}`, true);
        }else{
            xhr.open('GET', `../utils/poney/getter/getCoursByDatePoney.php?year=${date.getFullYear()}&month=${date.getMonth() + 1}&idPoney=${idPoney}`, true);
        }
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    console.log(response,  `../utils/poney/getter/getCoursByDatePoney.php?year=${date.getFullYear()}&month=0${date.getMonth() + 1}&idPoney=${idPoney}`);

                    if (Array.isArray(response)) {
                        resolve(response);
                    } else {
                        reject("Réponse inattendue du serveur : " + JSON.stringify(response));
                    }

                } else {
                    reject(`Erreur : ${xhr.status}`);
                }
            }
        };

        
        // Envoyer la requête
        xhr.send();
    });
    
}






function createCalendarPoney(month, year, idPoney){

    const calendrier = document.getElementById("calendrier");
    const monthDisplay = document.getElementById("month-display");

    monthDisplay.textContent = `${getMonthName(month)} ${year}`;


    calendrier.innerHTML = " ";
    let date = 1;
    const daysInMonth = getDaysInMonth(month + 1, year);
    
    const jours = ["Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"];
    let header = document.createElement("thead");
    let headerRow = document.createElement("tr");


    jours.forEach(jour => {
        let dayTitle = document.createElement("th");
        dayTitle.textContent = jour;
        headerRow.appendChild(dayTitle);
    });

    header.appendChild(headerRow);
    calendrier.appendChild(header);
   
    // partie poney
    getCoursPoneyByDate(new Date(year, month, 1), idPoney)
    .then((coursDuMois) => {
        const coursMap = new Map();
        coursDuMois.forEach(cours => {
            const date = new Date(cours.dateCours).getDate();
            coursMap.set(date, cours);
        });
        calendrierGraphiqueCreationPoney(calendrier, year, month, date, daysInMonth, coursMap);
        


    })
    .catch(error => console.error(error));

}
function calendrierGraphiqueCreationPoney(calendrier, year, month, date,daysInMonth, coursMap){


    for (let i = 0; i < 6; i++) {

        let week = document.createElement("tr");
        
        for (let j = 0; j < 7; j++) {

            if (date > daysInMonth) {
                break;
            }

            if(i === 0 && j < new Date(year, month, 1).getDay()-1 || date > daysInMonth){
                let day = document.createElement('td');
                day.innerHTML = "-";

                week.appendChild(day);
            }
            else{
                let day = document.createElement('td');
                day.innerHTML = date;
                // if(typeClient==="moniteur"){    
                //     day.addEventListener("click", () => {
                //         const pastilCliqueElements = calendrier.querySelectorAll('.PastiClique');

                //         // Parcourir chaque élément et supprimer la classe 'pastilClique'
                //         pastilCliqueElements.forEach((element) => {
                //             element.classList.remove('PastiClique');
                //         });


                //         day.classList.add("PastiClique");
                //         requestMoniteurCours(year, month+1, day.innerHTML);
                //     });                }
                if (coursMap.has(date)) {
                    day.classList.add("PastiCours");
                    
                    //     if(typeClient==="adherent"){    
                    //         day.classList.add("PastiCours");
                            // requestClientCours(new Date(year, month+1, date));
                    //     }
                day.addEventListener("click", () => {
                    // requestPoneyCours(year, month, day)
                    requestPoneyCours(year, month+1, day.innerHTML);
                });
                }

                week.appendChild(day);
                date++
            }
        }
        calendrier.appendChild(week);
    }
}



document.getElementById('photo').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('preview');
            preview.src = e.target.result;
            preview.style.display = "block";
        };
        reader.readAsDataURL(file);
    }
});



document.getElementById('photo').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('preview');
            preview.src = e.target.result;
            preview.style.display = "block";
        };
        reader.readAsDataURL(file);
    }
});
