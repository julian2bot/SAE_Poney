<?php

/**
  * regarde si l'utilisateur est connecté s'il l'est pas il est envoyer sur la page d'accueil
  *
  * @return void
  */
function estConnecte():void{

    if(!isset($_SESSION["connecte"])){
        header("Location: ../");
        exit;
    }
}

/**
  * regarde si l'utilisateur est moniteur s'il l'est pas il est envoyer sur la page d'accueil
  *
  * @return void
  */  
  function estMoniteur():void{
    
    if(!isset($_SESSION["connecte"]) OR $_SESSION["connecte"]["role"] !== "admin" OR $_SESSION["connecte"]["role"] !== "moniteur"){

        header("Location: ../");
        exit;

    }
}

/**
  * regarde si l'utilisateur est admin s'il l'est pas il est envoyer sur la page d'accueil
  *
  * @return void
  */  
  function estAdmin():void{
    
    if(!isset($_SESSION["connecte"]) OR $_SESSION["connecte"]["role"] !== "admin"){

        header("Location: ../");
        exit;

    }
}

/**
  * mets a jout la BD en cryptant les mdps
  *
  * @param PDO $bdd la base de donnée
  *
  * @return void
  */  
function CrypterMdp(PDO $bdd):void{

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

/**
  * get le role d'un utilisateur
  *
  * @param PDO la base de donnée, 
  * @param string $username nom user 
  *
  * @return string le role
  */  
function getRole(PDO $bdd, string $username): string{
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


/**
  * get le role d'un utilisateur
  *
  * @param PDO la base de donnée, 
  * @param string $username nom user 
  *
  * @return array les infos de l'user
  */  
function getInfo(PDO $bdd, string $username): array{
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

/**
  * get les poneys de la bd
  *
  * @param PDO la base de donnée, 
  *
  * @return array les poneys
  */  
function getPoney(PDO $bdd): array{
    $reqUser = $bdd->prepare("SELECT * FROM PONEY");
    $reqUser->execute();
    $info = $reqUser->fetchAll();
    return $info;
}

/**
  * get les clients de la bd
  *
  * @param PDO la base de donnée
  *
  * @return array les clients
  */  
function getClient(PDO $bdd):array{
    $reqUser = $bdd->prepare("SELECT * FROM CLIENT");
    $reqUser->execute();
    $info = $reqUser->fetchAll();
    return $info;
}


/**
  * get si la race du poney existe 
  *
  * @param PDO la base de donnée, 
  * @param string $nomRace nom de la race voulu 
  *
  * @return bool true s'il exite false sinon
  */  
function getRaceExistgetRace(PDO $bdd, string $nomRace):bool{
    $reqUser = $bdd->prepare("SELECT * FROM RACE WHERE nomRace = ?");
    $reqUser->execute(array($nomRace));
    $userExist = $reqUser->rowCount();
    return $userExist == 1;
}


/**
  * get les races de la bd
  *
  * @param PDO la base de donnée
  *
  * @return array toutes les races de poney de la bd
  */  
function getRaces(PDO $bdd):array{
    $reqUser = $bdd->prepare("SELECT * FROM RACE");
    $reqUser->execute();
    $info = $reqUser->fetchAll();
    return $info;
}


/**
  * get id maximun de la bd pour une table donnée
  *
  * @param PDO la base de donnée, 
  * @param string $idNom nom dans la table l'elements voulu 
  * @param string $table nom de la table voulu 
  *
  * @return int id maximal de la bd pour une table donnée
  */  
function getIdMax(PDO $bdd, string $idNom, string $table):int{
    $table = strtoupper($table);
    $reqUser = $bdd->prepare("SELECT MAX($idNom) FROM $table");
    $reqUser->execute(array());
    $info = $reqUser->fetch();
    if(isset($info)){
        return $info;
    }
    return 0;
}


/**
  * get les moniteurs de la bd
  *
  * @param PDO la base de donnée
  *
  * @return array liste des moniteurs de la bd
  */  
function getMoniteur(PDO $bdd):array{
    $reqUser = $bdd->prepare("SELECT * FROM MONITEUR");
    $reqUser->execute();
    $info = $reqUser->fetchAll();
    return $info;
}

/**
  * Renvoie une dispo particulière
  *
  * @param PDO la base de donnée, 
  * @param string usrname nom moniteur 
  * @param string $day date  
  * @param string startTime heure de début dispo  
  *
  * @return array la dispo
  */
function getDispo(PDO $bdd, string $username, string $day, string $startTime):array{
    $reqUser = $bdd->prepare("SELECT * FROM DISPONIBILITE WHERE usernameMoniteur = ? AND dateDispo = ? AND heureDebutDispo = ?");
    $reqUser->execute([$username,$day, $startTime]);
    $info = $reqUser->fetch();
    return $info;
}

/**
  * Renvoie les dispo pour une journée
  *
  * @param PDO la base de donnée, 
  * @param string usrname nom moniteur 
  * @param string $day date  
  *
  * @return array les dispos
  */  
function getDispoDay(PDO $bdd, string $username, string $day):array{
    $reqUser = $bdd->prepare("SELECT * FROM DISPONIBILITE WHERE usernameMoniteur = ? AND dateDispo = ?");
    $reqUser->execute([$username,$day]);
    $info = $reqUser->fetchAll();
    return $info;
}
/**
  * verifie l'existance du mail de la bd
  *
  * @param PDO la base de donnée, 
  * @param string $mail mail a vérifier 
  *
  * @return bool si le mail existe renvoie true, false sinon
  */  
function existMail(PDO $bdd, string $mail) : bool{

    $reqMail = $bdd->prepare("SELECT * FROM PERSONNE WHERE mail = ?");
    $reqMail->execute(array($mail));
    return $reqMail->rowCount() >=1;
}

/**
  * verifie l'existance du user de la bd
  *
  * @param PDO la base de donnée, 
  * @param string $user mail a vérifier 
  *
  * @return bool si l'user existe renvoie true, false sinon
  */  
function existUsername(PDO $bdd, string $username) : bool{
    $reqMail = $bdd->prepare("SELECT * FROM PERSONNE WHERE username = ?");
    $reqMail->execute(array($username));
    return $reqMail->rowCount() >=1;
}

/**
  * verifie l'existance d'une dispo
  *
  * @param PDO la base de donnée, 
  * @param string usrname nom moniteur 
  * @param string $day date  
  *
  * @return bool si la dispo existe renvoie true, false sinon
  */  
function existDateDispoDay(PDO $bdd,string $username,string  $day):bool{
    $reqMail = $bdd->prepare("SELECT * FROM DISPONIBILITE WHERE usernameMoniteur = ? AND dateDispo = ?");
    $reqMail->execute(array($username,$day));
    return $reqMail->rowCount() >=1;
}


/**
  * Renvoie si il y a un chevauchement entre deux période horaire
  *
  * @param PDO la base de donnée, 
  * @param string $heureDebut heure de début période 1 
  * @param string $heureFin heure de fin période 1   
  * @param string $heureDebut2 heure de début période 2
  * @param string $heureFin2 heure de fin période 2
  *
  * @return bool chevauchement
  */  
function chevauchementHeure(PDO $heureDebut,string $heureFin,string $heureDebut2,string $heureFin2): bool {
    $debut1 = strtotime($heureDebut);
    $fin1 = strtotime($heureFin);
    $debut2 = strtotime($heureDebut2);
    $fin2 = strtotime($heureFin2);

    return $debut1 <= $fin2 && $debut2 <= $fin1;
}

/**
  * verifie si la dispo donné entre en conflit avec celles existantes
  *
  * @param PDO la base de donnée, 
  * @param string usrname nom moniteur 
  * @param string $day date  
  * @param string $heureDebut heure de début période
  * @param string $heureFin heure de fin période
  * @param string $heureDebutEviter heure de début à éviter (pour la modification)
  *
  * @return bool si la dispo donné entre en conflit avec celles existantes
  */  
function existDateDispoConflit(PDO $bdd,string $username,string $day,string $heureDebut,string $heureFin,string $heureDebutEviter = ""){
    $dispoDay = getDispoDay($bdd,$username, $day);
    foreach ($dispoDay as $dispo) {
        if(($heureDebutEviter == "" || $heureDebutEviter != $dispo["heureDebutDispo"]) && chevauchementHeure($heureDebut, $heureFin, $dispo["heureDebutDispo"], $dispo["heureFinDispo"])){
            echo $heureDebutEviter, $dispo["heureDebutDispo"], "<br>";
            return true;
        }
    }
    return false;
}

/**
  * Transforme les heures au format "00:00" en float 0.0
  *
  * @param string heure au format "00:00", 
  *
  * @return float la version float
  */  
function convertTimeToFloat(string $time):float{
    $timeList = explode(':', $time);
    return (int)$timeList[0] + ($timeList[1] == "30" ? 0.5 : 0);
}

/**
  * Transforme les float 0.0 au format "00:00" 
  *
  * @param float temps 
  *
  * @return string heure au format "00:00"
  */  
function convertFloatToTime(float $time):string{
    $whole = (string)floor($time); 
    $fraction = $time - $whole;
    if(strlen($whole)<2){
        $whole = str_pad($whole,2,"0",STR_PAD_LEFT);
    }
    return implode(array($whole, ":", ($fraction == 0.5 ? "30" : "00")));
}

/**
  * get verifie l'exis d'une reservation pour une date donnée
  *
  * @param PDO la base de donnée, 
  * @param string $client nom client 
  * @param string $date date  
  *
  * @return array information a une date et un utilisateur donnée
  */  
// nom du cours, heure du cours(horaire) et activite : a une date donnee 
function getInfoByDate(PDO $bdd, string $client, string $date):array{
    $reqUser = $bdd->prepare("SELECT  heureDebutCours, activite, nomCours, day(dateCours) as day FROM RESERVATION NATURAL JOIN COURS NATURAL JOIN REPRESENTATION WHERE usernameClient = ? AND dateCours = ?");
    $reqUser->execute([$client, $date]);
    $info = $reqUser->fetchAll();
    return $info;
}

/**
  * get toutes les informations pour un mois donnée
  *
  * @param PDO la base de donnée, 
  * @param string $client nom client
  * @param string $month le mois 
  * @param string $year l'année 
  *
  * @return array liste information sur le mois 
  */  
function getAllInfoByMonth(PDO $bdd, string $client, string $month, string $year):array{
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

/**
  * format une heure decimal
  *
  * @param float $heureDecimal l'heure 
  *
  * @return string heure formaté
  */  
function formatHeure(float $heureDecimal):string {
    $heure = floor($heureDecimal);  
    $minute = round(($heureDecimal - $heure) * 60); 

    return sprintf("%02d:%02d", $heure, $minute);
}

/**
  * creer une pop up
  *
  * @param string $message le message de la pop up 
  * @param float $succes si la pop up est un succes ou err
  *
  * @return void
  */ 
function createPopUp(string $message, bool $success=true):void{
    $_SESSION["popUp"] = [];
    $_SESSION["popUp"]["success"] = $success;
    $_SESSION["popUp"]["message"] = $message;
}

/**
  * creer un calendrier avec toute les informations des cours dans les cases correspondantes
  *
  * @param PDO la base de donnée, 
  * @param string $client l'username du client 
  *
  * @return void 
  */  
function creerCalendrier(PDO $bdd, string $client):void{
    $Days = 1;
    
    $date = new DateTime();
    
    // TODO: changer la date juste commenté cette instruction pour avoit la date de la journée
    // $date->setDate("2023","12","1");
    $date->setDate($date->format('Y'), $date->format('m'), 1);

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

/**
  * get les informations d'un cours dans la bd
  *
  * @param PDO la base de donnée, 
  * @param int $idcours id d'un cours 
  * @param string $dateCours la date du cours 
  * @param float $heureDebutCours l'heure cours 
  *
  * @return array les informations sur un cours a une date / id donnée
  */  
function getInfoCours(PDO $bdd, int $idcours, string $dateCours, float $heureDebutCours):array{
    $reqUser = $bdd->prepare("SELECT idCours, usernameMoniteur, nomNiveau, nomCours, duree, prix, nbMax, dateCours, heureDebutCours FROM REPRESENTATION NATURAL JOIN COURS NATURAL JOIN NIVEAU WHERE idCours = ? AND dateCours = ? AND heureDebutCours = ?");
    $reqUser->execute([$idcours, $dateCours, $heureDebutCours]);
    return $reqUser->fetch();    
}


/**
  * formater un cours
  *
  * @param PDO la base de donnée, 
  * @param string $date la date du cours
  * @param float $heureDebut le debut du cours (l'heure)
  * @param float $dureeHeures la duree 
  *
  * @return string chaine de caractere formaté pour un cours a une date / heure debut et fin donnée 
  */  
function formatCours(string $date, float $heureDebut, float $dureeHeures):string {
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



/**
  * upDate le moniteur et client dans la BD et dans le $_SESSION
  *
  * @param PDO la base de donnée, 
  * @param string $oldUsername username du client non changé
  * @param string $username username du client possiblement changé
  * @param string $prenom prenom client
  * @param string $nom nom client
  * @param string $mail email du client
  * @param string $role role du client (admin client moniteur)
  * @param array $info les infos du client non edit mets qu'on remets dans les informations 
  *
  * @return array retourne se qui va etre dans le $_SESSION
  */  
function updateMoniteur(PDO $bdd, string $oldUsername, string $username ,string $prenom , string $nom , string $mail, string $role, array $info):array{
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

