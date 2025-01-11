function getsolde(userId, callback) {
    const xhr = new XMLHttpRequest();
    
    // Configurer la requête GET
    xhr.open("POST", `../utils/client/getter/getSoldeClient.php?username=${userId}`, true);
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                console.log(response["solde"]);
                // return response["solde"];
                callback(response["solde"]);

            } else {
                console.log(`Erreur : ${xhr.status}`);
                callback(0);
            }
        }
    };

    
    // Envoyer la requête
    xhr.send();

}

function add100ToSolde(userId) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../utils/client/update/updateSoldeClient.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                
                getsolde(userId, function (solde) {
                    showPopUp(`Votre solde a été crédité de 100€. Vous avez maintenant ${solde}€`);
                });
                // showPopUp(`Votre solde a été crédité de 100€ vous avez ${getsolde(userId)}`);
                // alert(xhr.responseText);
            } else {
                console.error("Erreur : " + xhr.status);
                showPopUp("le montant n'a pas pu etre ajouter");

            }
        }
    };

    // Envoyer les données nécessaires
    xhr.send("username=" + encodeURIComponent(userId));

}