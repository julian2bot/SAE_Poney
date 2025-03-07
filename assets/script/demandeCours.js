let abortControllerClient = null;
let abortControllerMoniteur = null;

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

function setDate(valueDate){
    document.getElementById("dateDemandeCours").value = valueDate;

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
                day.addEventListener("click", () => {
                    // TODO
                    // requestMoniteurCours(year, month+1, day.innerHTML);
                    setDate(`${year}-${month+1}-${day.innerHTML}`)
                    document.querySelectorAll(".PastiCours").forEach(td => td.classList.remove("PastiCours"));

                    day.classList.add("PastiCours");

                });                

                week.appendChild(day);
                date++
            }
        }
        calendrier.appendChild(week);
    }

}


// function calendrierGraphiqueCreation(calendrier, year, month, date,daysInMonth, coursMap, typeClient){

// }



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


document.getElementById("ReserverValider").addEventListener("click", function(event) {
    const hiddenInput = document.getElementById("dateDemandeCours");
    if (!hiddenInput.value) {
        alert("Veuillez remplir la date.");
        event.preventDefault(); // Empêche la soumission du formulaire
    }
    else if(!checkRadioSelected()){
        alert("Veuillez sélectionner un poney.");
        event.preventDefault(); // Empêche la soumission du formulaire
    }
});

function checkRadioSelected(){
    let lesRadios = document.getElementsByName("poneySelectionne");
    for (const rad of lesRadios) {
        if(rad.checked){
            return true;
        }
    }
    return false;
}