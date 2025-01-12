// dans le fichier il y a toute la gestion des calendriers (affichage + gestion serveur client)
let abortControllerClient = null;
let abortControllerMoniteur = null;

function convertFloatToTime(time) {
    let whole = Math.floor(time).toString();
    let fraction = time - Math.floor(time);

    if (whole.length < 2) {
        whole = whole.padStart(2, "0");
    }

    return `${whole}:${fraction === 0.5 ? "30" : "00"}`;
}

function requestClientCours(year, month, day) {
    if (abortControllerClient) {
        abortControllerClient.abort();
    }
    // Créer un nouveau contrôleur pour la nouvelle requête
    abortControllerClient = new AbortController();

    const signal = abortControllerClient.signal;

    
    const xhr = new XMLHttpRequest();
    // Configurer la requête GET
    xhr.open('GET', `../utils/client/getter/getCoursByDateEntiere.php?date=${year+'-'+month+'-'+day}`, true);
    
    // Définir une fonction de callback pour gérer la réponse
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Manipuler les données de la réponse (par exemple, afficher les résultats)
            const response = JSON.parse(xhr.responseText);
            const calendrier = document.getElementById("calendrier");

            const lesInfos = document.getElementById("infoCours");
            if(!lesInfos.classList.contains("open"))
                lesInfos.classList.add("open");

            if(!calendrier.classList.contains("open"))
                calendrier.classList.add("open");


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
                // Object sous la forme:
                // {
                //     "0": 3,
                //     "1": "moniteur1",
                //     "2": "2023-12-01",
                //     "3": "21.0",
                //     "4": null,
                //     "5": 7,
                //     "6": "Perfectionnement Galop 3",
                //     "7": 2,
                //     "8": 40,
                //     "9": 1,
                //     "idCours": 3,
                //     "usernameMoniteur": "moniteur1",
                //     "dateCours": "2023-12-01",
                //     "heureDebutCours": "21.0",
                //     "activite": null,
                //     "idNiveau": 7,
                //     "nomCours": "Perfectionnement Galop 3",
                //     "duree": 2,
                //     "prix": 40,
                //     "nbMax": 1
                // }

                let divInfo = document.createElement("div");
                divInfo.classList.add("infoDivCours");

                let divGauche = document.createElement("div");
                divGauche.classList.add("infoDivCoursGauche");

                let heureDebutCours = document.createElement("p");
                let nomCoursP = document.createElement("p");
                let strHeureDeb = convertFloatToTime(unCours.heureDebutCours);
                let strHeureFin = convertFloatToTime(parseFloat(unCours.heureDebutCours) + unCours.duree);
                heureDebutCours.innerHTML = strHeureDeb +' - '+ strHeureFin; 
                // heureDebutCours.innerHTML = unCours.heureDebutCours +' - '+ (unCours.heureDebutCours + unCours.duree); 
                nomCoursP.innerHTML = unCours.nomCours ? unCours.nomCours : "Cours poney"; 

                let nbPlaceRestante = document.createElement("p");
                nbPlaceRestante.innerHTML = "Places: "+ unCours.restant;

                divGauche.appendChild(heureDebutCours); 
                divGauche.appendChild(nbPlaceRestante); 
                divInfo.appendChild(divGauche); 
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

function addFloatTimes(startTime, endTime) {
    // console.log(startTime, endTime, startTime + endTime)
    const totalTime = parseFloat(startTime) + parseFloat(endTime); // Additionner les heures en float
    // console.log(totalTime)
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


function requestMoniteurCours(year, month, day) {

    if (abortControllerMoniteur) {
        abortControllerMoniteur.abort();
    }
    // Créer un nouveau contrôleur pour la nouvelle requête
    abortControllerMoniteur = new AbortController();

    const signal = abortControllerMoniteur.signal;

    
    const xhr = new XMLHttpRequest();
    
    // Configurer la requête GET
    xhr.open('GET', `../utils/moniteur/getter/getMoniteurACoursOuPas.php?date=${year+'-'+month+'-'+day}&username=${username.value}`, true);

    // Définir une fonction de callback pour gérer la réponse
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Manipuler les données de la réponse (par exemple, afficher les résultats)
            const response = JSON.parse(xhr.responseText);

            const calendrier = document.getElementById("calendrier");

            const lesInfos = document.getElementById("infoCours");
            if(!lesInfos.classList.contains("open"))
                lesInfos.classList.add("open");

            if(!calendrier.classList.contains("open"))
                calendrier.classList.add("open");

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
                let strHeureDeb = convertFloatToTime(unCours.heureDebutCours);
                let strHeureFin = convertFloatToTime(parseFloat(unCours.heureDebutCours) + unCours.duree);
                heureDebutCours.innerHTML = strHeureDeb +' - '+ strHeureFin; 
                nomCoursP.innerHTML = unCours.nomCours ? unCours.nomCours : "Cours poney"; 
                divInfo.appendChild(heureDebutCours);
                lesInfos.appendChild(divInfo);

                
                divInfo.appendChild(nomCoursP);
                
                divInfo.addEventListener("click", function() {
                    alert(`Vous avez cliqué sur le cours du ${unCours.dateCours} à ${unCours.heureDebutCours} avec le moniteur: ${unCours.heureDebutCours} le cours dur ${unCours.duree}h `);
                });


                
            });
            
            let aCreerCoursDIv = document.createElement("div");
            aCreerCoursDIv.classList.add("addCoursDiv");
            let aCreerCours = document.createElement("a");
            aCreerCours.classList.add("addCours");
            aCreerCours.innerHTML= '+';
            // aCreerCours.href= `creerCours.php?date=${year+'-'+month+'-'+day}`; // TODO
            aCreerCours.href= `creerCours.php?month=${month}&year=${year}&day=${day}`;

            aCreerCoursDIv.appendChild(aCreerCours);
            lesInfos.appendChild(aCreerCoursDIv);
        }
    };
    
    // Envoyer la requête
    xhr.send();

    
}

function getMoniteurACoursOuPas(date) {
    if (abortControllerMoniteur) {
        abortControllerMoniteur.abort();
    }

    // Créer un nouveau contrôleur
    abortControllerMoniteur = new AbortController();
    const signal = abortControllerMoniteur.signal;

    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        const username = document.getElementById("username");

        // Configurer la requête GET
        if((date.getMonth()+1)<10){
            xhr.open('GET', `../utils/moniteur/getter/getCoursByDateMoniteur.php?year=${date.getFullYear()}&month=0${date.getMonth()+1}&username=${username.value}`, true);
        }else{
            xhr.open('GET', `../utils/moniteur/getter/getCoursByDateMoniteur.php?year=${date.getFullYear()}&month=${date.getMonth()+1}&username=${username.value}`, true);
        }

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
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

function getCoursClientByDate(date) {
    if (abortControllerClient) {
        abortControllerClient.abort();
    }

    // Créer un nouveau contrôleur
    abortControllerClient = new AbortController();
    const signal = abortControllerClient.signal;

    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        
        // Configurer la requête GET
        if((date.getMonth() + 1)<10){
            xhr.open('GET', `../utils/client/getter/getCoursByDate.php?year=${date.getFullYear()}&month=0${date.getMonth() + 1}`, true);
        }else{
            xhr.open('GET', `../utils/client/getter/getCoursByDate.php?year=${date.getFullYear()}&month=${date.getMonth() + 1}`, true);
        }
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    console.log(response, `../utils/client/getter/getCoursByDate.php?year=${date.getFullYear()}&month=${date.getMonth() + 1}`);

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

function resetInfo(texte="Pas de cours"){
    const calendrier = document.getElementById("calendrier");

    const lesInfos = document.getElementById("infoCours");

    if(lesInfos.classList.contains("open"))
        lesInfos.classList.remove("open");

    if(calendrier.classList.contains("open"))
        calendrier.classList.remove("open");

    lesInfos.innerHTML = "";
    let p = document.createElement("p");
    p.innerHTML = texte;

    lesInfos.appendChild(p);
}



function createCalendar(month, year){

    const calendrier = document.getElementById("calendrier");
    const monthDisplay = document.getElementById("month-display");

    resetInfo();

    monthDisplay.textContent = `${getMonthName(month)} ${year}`;


    calendrier.innerHTML = "";
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
    
    if(document.getElementById("clientmoniteur").value === "moniteur"){
        
        // partie moniteur
        getMoniteurACoursOuPas(new Date(year, month, 1))
        .then((coursDuMois) => {

            const coursMap = new Map();
            coursDuMois.forEach(cours => {
                const date = new Date(cours.dateCours).getDate();
                coursMap.set(date, cours);
            });

            calendrierGraphiqueCreation(calendrier, year, month, date, daysInMonth, coursMap, "moniteur");

        


        })
        .catch(error => console.error(error));
    }

    else{
        // partie client
        getCoursClientByDate(new Date(year, month, 1))
        .then((coursDuMois) => {
            const coursMap = new Map();
            coursDuMois.forEach(cours => {
                const date = new Date(cours.dateCours).getDate();
                coursMap.set(date, cours);
            });
            calendrierGraphiqueCreation(calendrier, year, month, date, daysInMonth, coursMap, "adherent");
            


        })
        .catch(error => console.error(error));

    }
}
function calendrierGraphiqueCreation(calendrier, year, month, date,daysInMonth, coursMap, typeClient){


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
                if(typeClient==="moniteur"){    
                    day.addEventListener("click", () => {
                        const pastilCliqueElements = calendrier.querySelectorAll('.PastiClique');

                        // Parcourir chaque élément et supprimer la classe 'pastilClique'
                        pastilCliqueElements.forEach((element) => {
                            element.classList.remove('PastiClique');
                        });


                        day.classList.add("PastiClique");
                        requestMoniteurCours(year, month+1, day.innerHTML);
                    });                }
                if (coursMap.has(date)) {
                    day.classList.add("PastiCours");
                    
                    if(typeClient==="adherent"){    
                        day.classList.add("PastiCours");
                        day.addEventListener("click", () => {
                          
                            // requestClientCours(new Date(year, month+1, date));
                            requestClientCours(year, month+1, day.innerHTML);
                        });
                    }
                }

                week.appendChild(day);
                date++
            }
        }
        calendrier.appendChild(week);
    }
}
const currentDate = new Date();
createCalendar(currentDate.getMonth(), currentDate.getFullYear());

currentMonth = currentDate.getMonth();
currentYear = currentDate.getFullYear();

document.getElementById("prev-month").addEventListener("click", function() {
    if (abortControllerClient) abortControllerClient.abort();
    if (abortControllerMoniteur) abortControllerMoniteur.abort();

    if (currentMonth === 0) {
        currentMonth = 11; // Décembre
        currentYear--;
    } else {
        currentMonth--;
    }
    createCalendar(currentMonth, currentYear);
});

document.getElementById("next-month").addEventListener("click", function() {
    if (abortControllerClient) abortControllerClient.abort();
    if (abortControllerMoniteur) abortControllerMoniteur.abort();

    if (currentMonth === 11) {
        currentMonth = 0; // Janvier
        currentYear++;
    } else {
        currentMonth++;
    }
    createCalendar(currentMonth, currentYear);
});


