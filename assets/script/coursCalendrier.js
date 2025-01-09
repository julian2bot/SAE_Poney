// dans le fichier il y a toute la gestion des calendriers (affichage + gestion serveur client)
let abortControllerClient = null;
let abortControllerMoniteur = null;



function requestClientCours(year, month, day) {
    if (abortControllerClient) {
        abortControllerClient.abort();
    }
    // console.log("date", date , date.getFullYear()+'-'+(date.getMonth())+'-'+date.getDate())
    // Créer un nouveau contrôleur pour la nouvelle requête
    abortControllerClient = new AbortController();

    const signal = abortControllerClient.signal;

    
    const xhr = new XMLHttpRequest();
    console.log(`${year+'-'+month+'-'+day}`);
    // Configurer la requête GET
    xhr.open('GET', `../utils/getCoursByDateEntiere.php?date=${year+'-'+month+'-'+day}`, true);
    
    // Définir une fonction de callback pour gérer la réponse
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Manipuler les données de la réponse (par exemple, afficher les résultats)
            const response = JSON.parse(xhr.responseText);
            console.log(response); // Affiche les résultats dans la console
            // Par exemple, mettre à jour un élément HTML avec les résultats
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

                let heureDebutCours = document.createElement("p");
                let nomCoursP = document.createElement("p");
                heureDebutCours.innerHTML = unCours.heureDebutCours +' - '+ (unCours.heureDebutCours + unCours.duree); 
                nomCoursP.innerHTML = unCours.nomCours ? unCours.nomCours : "Cours poney"; 
                divInfo.appendChild(heureDebutCours); 
                lesInfos.appendChild(divInfo);

                
                divInfo.appendChild(nomCoursP);
                
                divInfo.addEventListener("click", function() {
                    // alert(`Vous avez cliqué sur le cours id ${unCours.idCours}, date ${unCours.dateCours} heure ${unCours.heureDebutCours}`);
                    location.href = `./reserverCours.php?idcours=${unCours.idCours}&dateCours=${unCours.dateCours}&heureCours=${unCours.heureDebutCours}`
                });


                console.log(unCours);
            });

        }
    };
    
    // Envoyer la requête
    xhr.send();

    // console.log(date.getFullYear()+'-'+(date.getMonth())+'-'+date.getDate());
    
}

function requestMoniteurCours(year, month, day) {
    const xhr = new XMLHttpRequest();
    
    // Configurer la requête GET
    // xhr.open('GET', `../utils/getCoursByDate.php?date=`, true);
    xhr.open('GET', `../utils/getMoniteurACoursOuPas.php?date=${year+'-'+month+'-'+day}&username=${username.value}`, true);

    // Définir une fonction de callback pour gérer la réponse
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Manipuler les données de la réponse (par exemple, afficher les résultats)
            const response = JSON.parse(xhr.responseText);
            console.log(response); // Affiche les résultats dans la console
            // Par exemple, mettre à jour un élément HTML avec les résultats
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
                heureDebutCours.innerHTML = unCours.heureDebutCours +' - '+ (unCours.heureDebutCours + unCours.duree); 
                nomCoursP.innerHTML = unCours.nomCours ? unCours.nomCours : "Cours poney"; 
                divInfo.appendChild(heureDebutCours);
                lesInfos.appendChild(divInfo);

                
                divInfo.appendChild(nomCoursP);
                
                divInfo.addEventListener("click", function() {
                    alert(`Vous avez cliqué sur le cours du ${unCours.dateCours} à ${unCours.heureDebutCours} avec le moniteur: ${unCours.heureDebutCours} le cours dur ${unCours.duree}h `);
                    // location.href = `./reserverCours.php?idcours=${unCours.idCours}&dateCours=${unCours.dateCours}&heureCours=${unCours.heureDebutCours}`
                });


                
                console.log(unCours);
            });
            
            let aCreerCoursDIv = document.createElement("div");
            aCreerCoursDIv.classList.add("addCoursDiv");
            let aCreerCours = document.createElement("a");
            aCreerCours.classList.add("addCours");
            aCreerCours.innerHTML= '+';
            aCreerCours.href= `creerCours.php?date=${year+'-'+month+'-'+day}`; // TODO

            aCreerCoursDIv.appendChild(aCreerCours);
            lesInfos.appendChild(aCreerCoursDIv);
        }
    };
    
    // Envoyer la requête
    xhr.send();

    // console.log(date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate());
    
}

// function getMoniteurACoursOuPas(date){
//     return new Promise((resolve, reject) => {
//         const xhr = new XMLHttpRequest();
        
//         const username = document.getElementById("username");
//         console.log(username.value);
//         // Configurer la requête GET
//         xhr.open('GET', `../utils/getMoniteurACoursOuPas.php?date=${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}&username=${username.value}`, true);
        
//         xhr.onreadystatechange = function() {
//             if (xhr.readyState === 4) {
//                 if (xhr.status === 200) {
//                     const response = JSON.parse(xhr.responseText);

//                     if (response.length === 0) {
//                         console.log("Pas de cours le " + date);
//                         resolve(true);
//                     } else {
//                         console.log("Cours prévu le " + date);
//                         resolve(false);
//                     }
//                 } else {
//                     reject(`Erreur : ${xhr.status}`);
//                 }
//             }
//         };

        
//         // Envoyer la requête
//         xhr.send();
//         console.log(date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate());
//     });
// }

function getMoniteurACoursOuPas(date) {
    if (abortControllerClient) {
        abortControllerClient.abort();
    }

    // Créer un nouveau contrôleur
    abortControllerClient = new AbortController();
    const signal = abortControllerClient.signal;

    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        const username = document.getElementById("username");

        console.log(`year=${date.getFullYear()}&month=${date.getMonth()+1}&username=${username.value}`)
        // Configurer la requête GET
        xhr.open('GET', `../utils/getCoursByDateMoniteur.php?year=${date.getFullYear()}&month=${date.getMonth()+1}&username=${username.value}`, true);

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    console.log(response)
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
        // console.log(date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate());
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
        xhr.open('GET', `../utils/getCoursByDate.php?year=${date.getFullYear()}&month=${date.getMonth() + 1}`, true);
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    console.log(response)
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
        // console.log(date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate());
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



function createCalendar(month, year){

    const calendrier = document.getElementById("calendrier");
    const monthDisplay = document.getElementById("month-display");

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
    
    let yaCours = false;


    if(document.getElementById("clientmoniteur").value === "moniteur"){
        
        // partie moniteur
        console.log('getMoniteurACoursOuPas(new Date('+year, month, 1)
        getMoniteurACoursOuPas(new Date(year, month, 1))
        .then((coursDuMois) => {

            const coursMap = new Map();
            coursDuMois.forEach(cours => {
                const date = new Date(cours.dateCours).getDate();
                coursMap.set(date, cours);
            });
            console.log(coursDuMois, coursMap)
            console.log(year, month+1, date)

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
                        // yaCours = getYaUnCoursOuPas(new Date(year, month, day.innerHTML));
                        // console.log(yaCours);
                        if (coursMap.has(date)) {
                            day.classList.add("PastiCours");
                        
                        }
                        day.addEventListener("click", () => {

                            requestMoniteurCours(year, month+1, day.innerHTML);
                        });
                        week.appendChild(day);
                        date++
                    }
                }
                calendrier.appendChild(week);
            }
        
            // if (!result) {
            //     day.classList.add("PastiCours");
            //     // console.log("Pas de cours");
            // } 

        })
        .catch(error => console.error(error));
    }
        // day.addEventListener("click", function() {
        //     // alert(`Vous avez cliqué sur le ${day.innerHTML}`);
        //     requestClientCours(new Date(year, month, day.innerHTML));
        // });
    else{
        // partie client
        getCoursClientByDate(new Date(year, month, 1))
        .then((coursDuMois) => {
            const coursMap = new Map();
            coursDuMois.forEach(cours => {
                const date = new Date(cours.dateCours).getDate();
                coursMap.set(date, cours);
            });
            console.log(coursMap)
            console.log(year, month+1, date)

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
                        // yaCours = getYaUnCoursOuPas(new Date(year, month, day.innerHTML));
                        // console.log(yaCours);
                        if (coursMap.has(date)) {
                            day.classList.add("PastiCours");
                            
                            day.addEventListener("click", () => {
                                console.log("requestClientCours", year, month+1, day.innerHTML)

                                // requestClientCours(new Date(year, month+1, date));
                                requestClientCours(year, month+1, day.innerHTML);
                            });
                        }
                        week.appendChild(day);
                        date++
                    }
                }
                calendrier.appendChild(week);
            }
        
            // if (!result) {
            //     day.classList.add("PastiCours");
            //     // console.log("Pas de cours");
            // } 

        })
        .catch(error => console.error(error));

        // day.addEventListener("click", function() {
        //     // alert(`Vous avez cliqué sur le ${day.innerHTML}`);
        //     requestClientCours(new Date(year, month, day.innerHTML));
        // });
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


