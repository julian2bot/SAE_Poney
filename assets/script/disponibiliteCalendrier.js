function createCalendarDispo(month, year){
    const calendrier = document.getElementById("calendrier-disponibilite");
    const monthDisplay = document.getElementById("month-display-disponibilite");

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
                    // getMoniteurACoursOuPas(new Date(year, month, day.innerHTML))
                    // .then(result => {
                    //     if (!result) {
                    //         day.classList.add("PastiCours");
                    //         console.log("FDPNIQUE TES MORTS");
                    //     } 
                    //     // else {
                    //     // }
                    // })
                    // .catch(error => console.error(error));
                    
                    // day.addEventListener("click", function() {
                    //     // alert(`Vous avez cliqué sur le ${day.innerHTML}`);
                    //     // requestClientCours(new Date(year, month, day.innerHTML));
                    //     // TODO
                    //     // requestMiniteurCours(new Date(year, month, day.innerHTML));

                    // });
                }
                else{

                    // getYaUnCoursOuPas(new Date(year, month, day.innerHTML))
                    // .then(result => {
                    //     if (!result) {
                    //         day.classList.add("PastiCours");
                    //         // console.log("Pas de cours");
                    //     } 
                    //     // else {
                    //     // }
                    // })
                    // .catch(error => console.error(error));

                    // day.addEventListener("click", function() {
                    //     // alert(`Vous avez cliqué sur le ${day.innerHTML}`);
                    //     requestClientCours(new Date(year, month, day.innerHTML));
                    // });
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


