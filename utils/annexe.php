<?php

function estConnecte(){

    if(!isset($_SESSION["connecte"])){
        header("Location: ../");
        exit;
    }
}
    
function estAdmin(){
    
    if(!isset($_SESSION["connecte"]) OR $_SESSION["connecte"]["role"] !== "admin"){

        header("Location: ../");
        exit;

    }
}

function CrypterMdp($bdd){

    $sql = "SELECT username, mdp FROM PERSONNE";
    $stmt = $bdd->query($sql);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $username = $row['username'];
        $mdp = $row['mdp'];

            $mdpCrypte = sha1($mdp);

            $updateSql = "UPDATE PERSONNE SET mdp = :mdp WHERE username = :username";
            $updateStmt = $bdd->prepare($updateSql);
            $updateStmt->execute([':mdp' => $mdpCrypte, ':username' => $username]);

            echo "Mot de passe de l'utilisateur $username a été crypté avec succès.<br>";
    }
}


// les getters

function getRole($bdd, $username): string{
    $reqUser = $bdd->prepare("SELECT * FROM MONITEUR WHERE usernameMoniteur = ?");
    $reqUser->execute(array($username));
    $userExist = $reqUser->rowCount();
    if($userExist == 1)
    {
        $userinfo = $reqUser->fetch();   
        return $userinfo['isAdmin'] ? "admin" : "moniteur";
    }
    else{
        $reqUser = $bdd->prepare("SELECT * FROM CLIENT WHERE usernameClient = ?");
        $reqUser->execute(array($username));
        $userExist = $reqUser->rowCount();
        if($userExist == 1)
        {
            return "client";
        }                
    }
    return "non-adherent";
}


function getInfo($bdd, $username){
    // $reqUser = $bdd->prepare("SELECT * FROM MONITEUR NATURAL JOIN PERSONNE WHERE username = ? AND usernameMoniteur = ?");
    $reqUser = $bdd->prepare("SELECT * FROM MONITEUR JOIN PERSONNE ON MONITEUR.usernameMoniteur = PERSONNE.username WHERE usernameMoniteur = ?");
    $reqUser->execute(array($username));
    $userExist = $reqUser->rowCount();
    $resultat = [];
    $resultat["username"] = $username;
    
    if($userExist == 1)
    {
        $info = $reqUser->fetch();
        $resultat["prenomPersonne"] = $info["prenomPersonne"];
        $resultat["nomPersonne"] = $info["nomPersonne"];
        $resultat["mail"] = $info["mail"];
        $resultat["salaire"] = $info["salaire"];
        $resultat["isAdmin"] = $info["isAdmin"];
        return $resultat;
    }
    else{
        $reqUser = $bdd->prepare("SELECT * FROM CLIENT JOIN PERSONNE ON CLIENT.usernameClient = PERSONNE.username WHERE usernameClient = ?");
        $reqUser->execute(array($username));
        $userExist = $reqUser->rowCount();
        if($userExist == 1)
        {
            $info=$reqUser->fetch();
            $resultat["prenomPersonne"] = $info["prenomPersonne"];
            $resultat["nomPersonne"] = $info["nomPersonne"];
            $resultat["mail"] = $info["mail"];
            $resultat["dateInscription"] = $info["dateInscription"];
            $resultat["poid"] = $info["poidsClient"];
            $resultat["solde"] = $info["solde"];
            return $resultat;
        }                
    }
    return array();
}

function getPoney($bdd){
    $reqUser = $bdd->prepare("SELECT * FROM PONEY");
    $reqUser->execute();
    $info = $reqUser->fetchAll();
    return $info;
}

function getClient($bdd){
    $reqUser = $bdd->prepare("SELECT * FROM CLIENT");
    $reqUser->execute();
    $info = $reqUser->fetchAll();
    return $info;
}


function getRace($bdd, $nomRace){
    $reqUser = $bdd->prepare("SELECT * FROM RACE WHERE nomRace = ?");
    $reqUser->execute(array($nomRace));
    $userExist = $reqUser->rowCount();
    return $userExist == 1;
}

function getRaces($bdd){
    $reqUser = $bdd->prepare("SELECT * FROM RACE");
    $reqUser->execute();
    $info = $reqUser->fetchAll();
    return $info;
}


function getIdMax($bdd, $idNom, $table){
    $table = strtoupper($table);
    $reqUser = $bdd->prepare("SELECT MAX($idNom) FROM $table");
    $reqUser->execute(array());
    $info = $reqUser->fetch();
    if(isset($info)){
        return $info;
    }
    return 0;
}


function getMoniteur($bdd){
    $reqUser = $bdd->prepare("SELECT * FROM MONITEUR");
    $reqUser->execute();
    $info = $reqUser->fetchAll();
    return $info;
}

function existMail($bdd, $mail) : bool{
    $reqMail = $bdd->prepare("SELECT * FROM PERSONNE WHERE mail = ?");
    $reqMail->execute(array($mail));
    return $reqMail->rowCount() >=1;
}

function existUsername($bdd, $username) : bool{
    $reqMail = $bdd->prepare("SELECT * FROM PERSONNE WHERE username = ?");
    $reqMail->execute(array($username));
    return $reqMail->rowCount() >=1;
}

// nom du cours, heure du cours(horaire) et activite : a une date donnee 
function getInfoByDate($bdd,$client, $date){
    $reqUser = $bdd->prepare("SELECT  heureDebutCours, activite, nomCours, day(dateCours) as day FROM RESERVATION NATURAL JOIN COURS NATURAL JOIN REPRESENTATION WHERE usernameClient = ? AND dateCours = ?");
    $reqUser->execute([$client, $date]);
    $info = $reqUser->fetchAll();
    return $info;
}


function getAllInfoByMonth($bdd, $client, $month, $year){
    $reqUser = $bdd->prepare("SELECT heureDebutCours, activite, nomCours, day(dateCours) as day 
                              FROM RESERVATION 
                              NATURAL JOIN COURS 
                              NATURAL JOIN REPRESENTATION 
                              WHERE usernameClient = ? 
                              AND MONTH(dateCours) = ? 
                              AND YEAR(dateCours) = ?");
    $reqUser->execute([$client, $month, $year]);
    $info = $reqUser->fetchAll();
    
    $coursesByDay = [];
    foreach ($info as $cours) {
        $coursesByDay[$cours['day']][] = $cours;
    }
    return $coursesByDay;
}

function formatHeure($heureDecimal) {
    $heure = floor($heureDecimal);  
    $minute = round(($heureDecimal - $heure) * 60); 

    return sprintf("%02d:%02d", $heure, $minute);
}


function creerCalendrier($bdd, $client){
    $Days = 1;
    
    $date = new DateTime();
    
    // TODO: changer la date juste commenté cette instruction pour avoit la date de la journée
    $date->setDate("2023","12","1");
 
    $nbJourDansMois = $date->format('t'); // 't' retourne le nombre de jours dans le mois
    $jourDebutMois = $date->format('N'); // Le jour de la semaine du 1er jour du mois (1 = lundi, 7 = dimanche)
    
    // header basique avec les jours
    echo '<table border="1">';
    echo '<tr>';
    echo '<th>Lundi</th>';
    echo '<th>Mardi</th>';
    echo '<th>Mercredi</th>';
    echo '<th>Jeudi</th>';
    echo '<th>Vendredi</th>';
    echo '<th>Samedi</th>';
    echo '<th>Dimanche</th>';
    echo '</tr>';
    
    $coursesByDay = getAllInfoByMonth($bdd, $client, $date->format('m'), $date->format('Y'));

    for ($i = 0; $i < 6; $i++) { 
        echo '<tr>';
        for ($j = 1; $j <= 7; $j++) {
            if ($Days > $nbJourDansMois) {
                break;
            }
            if (($j >= $jourDebutMois && $i === 0) || ($i !== 0 && $Days <= $nbJourDansMois)) {
                if (isset($coursesByDay[$Days])) {
                    echo "<td class='styled-cell hover'> $Days";
                    foreach ($coursesByDay[$Days] as $cours) {
                        echo "<div class='event-box'>
                                <h2 class='event-title'>{$cours['nomCours']}</h2>
                               "."<p>Horaires : " . formatHeure($cours['heureDebutCours']) . "</p>"."
                                <div class='event-details'>
                                    "."<p>Horaires : " . formatHeure($cours['heureDebutCours']) . "</p>"."
                                    <p>Lieu : XX rue du 16</p>
                                    <p>Modalités particulières</p>
                                </div>
                              </div>";
                    }
                    echo "</td>";
                } else {
                    echo "<td  class='styled-cell'>$Days</td>";
                }
                $Days++;
            } else {
                echo "<td></td>";
            }
            
        }
        echo '</tr>';
    }
    
    echo '</table>';

}


function getInfoCours($bdd, $idcours, $dateCours, $heureDebutCours){
    $reqUser = $bdd->prepare("SELECT idCours, usernameMoniteur, nomNiveau, nomCours, duree, prix, nbMax, dateCours, heureDebutCours FROM REPRESENTATION NATURAL JOIN COURS NATURAL JOIN NIVEAU WHERE idCours = ? AND dateCours = ? AND heureDebutCours = ?");
    $reqUser->execute([$idcours, $dateCours, $heureDebutCours]);
    return $reqUser->fetch();    
}

function formatCours($date, $heureDebut, $dureeHeures) {
    // Convertir la date au format souhaité
    $dateFormatee = date("d F", strtotime($date));

    // Créer une fonction pour formater l'heure
    $formatterHeure = function($heure) {
        $heures = floor($heure);
        $minutes = ($heure - $heures) * 60;
        return sprintf("%dh%02d", $heures, $minutes);
    };

    // Formater l'heure de début et l'heure de fin
    $heureDebutFormatee = $formatterHeure($heureDebut);
    $heureFinFormatee = $formatterHeure($heureDebut + $dureeHeures);

    // Retourner le texte final
    return "Début du cours du $dateFormatee à $heureDebutFormatee et fini à $heureFinFormatee";
}




function updateMoniteur($bdd, $oldUsername, $username ,$prenom ,$nom ,$mail, $role, $info){
    // Préparer la requête avec des ? pour les paramètres
    $updateSql = "UPDATE PERSONNE 
                  SET prenomPersonne = ?, 
                      nomPersonne = ?, 
                      mail = ? 
                  WHERE username = ?";

    $updateStmt = $bdd->prepare($updateSql);

    $result = $updateStmt->execute([$prenom, $nom, $mail, $oldUsername]);

    // Vérifier le résultat
    if ($result) {
        echo "Mise à jour réussie<br>";
    } else {
        $errorInfo = $updateStmt->errorInfo();
        echo "Erreur SQL : " . $errorInfo[2];
    }

    return array(
        "username" => $oldUsername,  // a voir pour edit ca en plus
        "prenom" => $prenom,
        "nom" => $nom,
        "mail" => $mail,
        "role" => $role,
        "info" => $info
    );
}

