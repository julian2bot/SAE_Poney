function sendAJAXRequest(date) {
    const xhr = new XMLHttpRequest();
    
    // Configurer la requête GET
    xhr.open('GET', `../utils/getCoursByDate.php?date=${date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate()}`, true);
    
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
            if(response[0]){
                
                let dateDuCours = document.createElement("p");
                dateDuCours.innerHTML = response[0].dateCours;
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
                    alert(`Vous avez cliqué sur le cours id ${unCours.idCours}, date ${unCours.dateCours} heure ${unCours.heureDebutCours}`);
                    location.href = `./reserverCours.php?idcours=${unCours.idCours}&dateCours=${unCours.dateCours}&heureCours=${unCours.heureDebutCours}`
                });


                console.log(unCours);
            });

        }
    };
    
    // Envoyer la requête
    xhr.send();

    console.log(date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate());
    
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
                day.addEventListener("click", function() {
                    // alert(`Vous avez cliqué sur le ${day.innerHTML}`);
                    sendAJAXRequest(new Date(year, month, day.innerHTML));
                });
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
    if (currentMonth === 0) {
        currentMonth = 11; // Décembre
        currentYear--;
    } else {
        currentMonth--;
    }
    createCalendar(currentMonth, currentYear);
});

document.getElementById("next-month").addEventListener("click", function() {
    if (currentMonth === 11) {
        currentMonth = 0; // Janvier
        currentYear++;
    } else {
        currentMonth++;
    }
    createCalendar(currentMonth, currentYear);
});


