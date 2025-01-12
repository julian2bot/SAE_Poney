function convertFloatToTime(time) {
    let whole = Math.floor(time).toString();
    let fraction = time - Math.floor(time);

    if (whole.length < 2) {
        whole = whole.padStart(2, "0");
    }

    return `${whole}:${fraction === 0.5 ? "30" : "00"}`;
}


function resetInfoDispo(texte="Aucune disponibilité"){
    const lesInfos = document.getElementById("info-disponibilite");
            
    const calendrier = document.getElementById("calendrier-disponibilite");

    if(lesInfos.classList.contains("open"))
        lesInfos.classList.remove("open");

    if(calendrier.classList.contains("open"))
        calendrier.classList.remove("open");

    lesInfos.innerHTML = "";
    let p = document.createElement("p");
    p.innerHTML = texte;

    lesInfos.appendChild(p);
}


function addDisponibiliteInfo(date) {
    const xhr = new XMLHttpRequest();
    
    // Configurer la requête GET
    xhr.open('GET', `../utils/moniteur/getter/getMoniteurDisponibiliteDate.php?date=${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}&username=${username.value}`, true);
    
    // Définir une fonction de callback pour gérer la réponse
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Manipuler les données de la réponse (par exemple, afficher les résultats)
            const response = JSON.parse(xhr.responseText);
            console.log(response); // Affiche les résultats dans la console
            // Par exemple, mettre à jour un élément HTML avec les résultats
            const lesInfos = document.getElementById("info-disponibilite");
            
            const calendrier = document.getElementById("calendrier-disponibilite");

            if(!lesInfos.classList.contains("open"))
                lesInfos.classList.add("open");

            if(!calendrier.classList.contains("open"))
                calendrier.classList.add("open");

            while (lesInfos.firstChild) {
                lesInfos.removeChild(lesInfos.firstChild);
            }
            let dateDeDispo = document.createElement("p");
            if(response[0]){
                
                dateDeDispo.innerHTML = response[0].dateDispo;
                lesInfos.appendChild(dateDeDispo);
            }else{
                dateDeDispo.innerHTML = "Pas de disponibilité";
                lesInfos.appendChild(dateDeDispo);
            }

            let aCreerDispoDiv = document.createElement("div");
            aCreerDispoDiv.classList.add("addCoursDiv");
            let aCreerDispo = document.createElement("a");
            aCreerDispo.classList.add("addCours");
            aCreerDispo.innerHTML= '+';
            aCreerDispo.href= `../page/disponibilite.php?date=${date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate()}`; // TODO

            aCreerDispoDiv.appendChild(aCreerDispo);
            lesInfos.appendChild(aCreerDispoDiv);

            response.forEach(uneDispo => {
                let divInfo = document.createElement("div");
                divInfo.classList.add("infoDivCours");

                let heureDebutDispo = document.createElement("p");
                let strHeureDeb = convertFloatToTime(uneDispo.heureDebutDispo);
                let strHeureFin = convertFloatToTime(uneDispo.heureFinDispo);
                heureDebutDispo.innerHTML = strHeureDeb +' - '+ strHeureFin; 
                divInfo.appendChild(heureDebutDispo);
                lesInfos.appendChild(divInfo);
                
                divInfo.addEventListener("click", function() {
                    alert(`Vous avez cliqué sur la dispo du ${uneDispo.dateDispo} de ${strHeureDeb} a ${strHeureFin}`);
                    window.location.href = `../page/modifierDisponibilite.php?dateDispo=${date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate()}&debutDispo=${uneDispo.heureDebutDispo}`;
                });
            });
        }
    };
    
    // Envoyer la requête
    xhr.send();

    console.log(date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate());
}

function getDisponibilte(date){
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        
        const username = document.getElementById("username");
        console.log(username.value);
        // Configurer la requête GET
        xhr.open('GET', `../utils/moniteur/getter/getMoniteurDisponibiliteDate.php?date=${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}&username=${username.value}`, true);
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);

                    if (response.length === 0) {
                        console.log("Pas de dispo le " + date);
                        resolve(true);
                    } else {
                        console.log("Dispo le " + date);
                        resolve(false);
                    }
                } else {
                    reject(`Erreur : ${xhr.status}`);
                }
            }
        };

        
        // Envoyer la requête
        xhr.send();
        console.log(date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate());
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

function createCalendarDispo(month, year){
    const calendrier = document.getElementById("calendrier-disponibilite");
    const monthDisplay = document.getElementById("month-display-disponibilite");
    resetInfoDispo();

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
                if(document.getElementById("clientmoniteur").value === "moniteur"){
                    getDisponibilte(new Date(year, month, day.innerHTML))
                    .then(result => {
                        if (!result) {
                            day.classList.add("PastiCours");
                        } 
                    })
                    .catch(error => console.error(error));
                    
                    day.addEventListener("click", function() {
                        addDisponibiliteInfo(new Date(year, month, day.innerHTML));
                    });
                }
                week.appendChild(day);
                date++
            }
        }
        calendrier.appendChild(week);
    }
}

const currentDateDispo = new Date();
createCalendarDispo(currentDateDispo.getMonth(), currentDateDispo.getFullYear());

let currentMonthDispo = currentDateDispo.getMonth();
let currentYearDispo = currentDateDispo.getFullYear();

document.getElementById("prev-month-disponibilite").addEventListener("click", function() {
    if (currentMonthDispo === 0) {
        currentMonthDispo = 11; // Décembre
        currentYearDispo--;
    } else {
        currentMonthDispo--;
    }
    createCalendarDispo(currentMonthDispo, currentYearDispo);
});

document.getElementById("next-month-disponibilite").addEventListener("click", function() {

    if (currentMonthDispo === 11) {
        currentMonthDispo = 0; // Janvier
        currentYearDispo++;
    } else {
        currentMonthDispo++;
    }
    createCalendarDispo(currentMonthDispo, currentYearDispo);
});


