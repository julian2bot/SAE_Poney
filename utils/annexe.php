<?php

/**
 * regarde si l'utilisateur est connecté s'il l'est pas il est envoyer sur la page d'accueil
 *
 * @return void
 */
function estConnecte(): void
{

	if (!isset($_SESSION["connecte"])) {
		header("Location: ../");
		exit;
	}
}

/**
 * regarde si l'utilisateur est moniteur s'il l'est pas il est envoyer sur la page d'accueil
 *
 * @return void
 */
function estMoniteur(): void
{

	if (!isset($_SESSION["connecte"]) || ($_SESSION["connecte"]["role"] !== "admin" && $_SESSION["connecte"]["role"] !== "moniteur")) {

		header("Location: ../");
		exit;

	}
}

/**
 * regarde si l'utilisateur est admin s'il l'est pas il est envoyer sur la page d'accueil
 *
 * @return void
 */
function estAdmin(): void
{

	if (!isset($_SESSION["connecte"]) or $_SESSION["connecte"]["role"] !== "admin") {

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
function CrypterMdp(PDO $bdd): void
{

	$sql = "SELECT username, mdp FROM PERSONNE";
	$stmt = $bdd->query($sql);

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$username = $row['username'];
		$mdp = $row['mdp'];

		$mdpCrypte = "ae3fc6fbe0c483e288ed135d174a3b5a2d4d733a";

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
function getRole(PDO $bdd, string $username): string
{
	$reqUser = $bdd->prepare("SELECT * FROM MONITEUR WHERE usernameMoniteur = ?");
	$reqUser->execute(array($username));
	$userExist = $reqUser->rowCount();
	if ($userExist == 1) {
		$userinfo = $reqUser->fetch();
		return $userinfo['isAdmin'] ? "admin" : "moniteur";
	} else {
		$reqUser = $bdd->prepare("SELECT * FROM CLIENT WHERE usernameClient = ?");
		$reqUser->execute(array($username));
		$userExist = $reqUser->rowCount();
		if ($userExist == 1) {
			return "client";
		}
	}
	return "non-adherent";
}

/**
 * get le niveau max d'une personne
 *
 * @param PDO la base de donnée, 
 * @param string $username nom user 
 *
 * @return int niveau max
 */
function getMaxNiveau(PDO $bdd, string $username): int
{
	$reqUser = $bdd->prepare("SELECT IFNULL(MAX(idNiveau),0) AS maxNiv FROM PERSONNE NATURAL LEFT JOIN OBTENTION WHERE username = ?");
	$reqUser->execute(array($username));
	return $reqUser->fetch()["maxNiv"] ?? 0;
}

function getMail(PDO $bdd, string $username):string{
    $reqUser = $bdd->prepare("SELECT mail FROM PERSONNE WHERE username = ?");
	$reqUser->execute(array($username));
	return $reqUser->fetch()["mail"];
}

function getPersonne(PDO $bdd, string $username):array{
    $reqUser = $bdd->prepare("SELECT * FROM PERSONNE WHERE username = ?");
	$reqUser->execute(array($username));
	return $reqUser->fetch();
}

/**
 * get le role d'un utilisateur
 *
 * @param PDO la base de donnée, 
 * @param string $username nom user 
 *
 * @return array les infos de l'user
 */
function getInfo(PDO $bdd, string $username): array
{
	// $reqUser = $bdd->prepare("SELECT * FROM MONITEUR NATURAL JOIN PERSONNE WHERE username = ? AND usernameMoniteur = ?");
	$reqUser = $bdd->prepare("SELECT * FROM PERSONNE NATURAL LEFT JOIN OBTENTION JOIN MONITEUR ON MONITEUR.usernameMoniteur = PERSONNE.username WHERE usernameMoniteur = ?");
	$reqUser->execute(array($username));
	$userExist = $reqUser->rowCount();
	$resultat = [];
	$resultat["username"] = $username;

	if ($userExist == 1) {
		$info = $reqUser->fetch();
		$resultat["prenomPersonne"] = $info["prenomPersonne"];
		$resultat["nomPersonne"] = $info["nomPersonne"];
		$resultat["mail"] = $info["mail"];
		$resultat["salaire"] = $info["salaire"];
		$resultat["isAdmin"] = $info["isAdmin"];
		$resultat["niveau"] = $info["idNiveau"] ?? 0;

		return $resultat;
	} else {
		$reqUser = $bdd->prepare("SELECT * FROM PERSONNE NATURAL LEFT JOIN OBTENTION JOIN CLIENT ON CLIENT.usernameClient = PERSONNE.username WHERE usernameClient = ?");
		$reqUser->execute(array($username));
		$userExist = $reqUser->rowCount();
		if ($userExist == 1) {
			$info = $reqUser->fetch();
			$resultat["prenomPersonne"] = $info["prenomPersonne"];
			$resultat["nomPersonne"] = $info["nomPersonne"];
			$resultat["mail"] = $info["mail"];
			$resultat["dateInscription"] = $info["dateInscription"];
			$resultat["poid"] = $info["poidsClient"];
			$resultat["solde"] = $info["solde"];
			$resultat["niveau"] = $info["idNiveau"] ??0;
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
function getPoney(PDO $bdd): array
{
	$reqUser = $bdd->prepare("SELECT * FROM PONEY");
	$reqUser->execute();
	$info = $reqUser->fetchAll();
	return $info;
}



/**
 * get les poneys de la bd
 *
 * @param PDO la base de donnée, 
 *
 * @return array les poneys
 */
function getPoneyById(PDO $bdd, int $idPoney): array
{
	$reqUser = $bdd->prepare("SELECT * FROM PONEY where idPoney = ?");
	$reqUser->execute([$idPoney]);
	$info = $reqUser->fetch();
	if (isset($info)) {
		return $info;
	}
	return array();
}

/**
 * get les clients de la bd
 *
 * @param PDO la base de donnée
 *
 * @return array les clients
 */
function getClient(PDO $bdd): array
{
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
function getRaceExist(PDO $bdd, string $nomRace): bool
{
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
function getRaces(PDO $bdd): array
{
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
function getIdMax(PDO $bdd, string $idNom, string $table): array
{
	$table = strtoupper($table);
	$reqUser = $bdd->prepare("SELECT MAX($idNom) FROM $table");
	$reqUser->execute(array());
	$info = $reqUser->fetch();
	if (isset($info)) {
		return $info;
	}
	return array();
}

/**
 * get le cours personalisé selon le niveau et la duree
 *
 * @param PDO la base de donnée
 * @param string niveau
 * @param string duree
 *
 * @return array cours perso
 */
function getCoursPerso(PDO $bdd, string $idNiveau, string $duree): array
{
	$reqUser = $bdd->prepare("SELECT * FROM COURS WHERE idNiveau = ? AND duree = ? AND nomCours LIKE ?");
	$reqUser->execute(array($idNiveau, $duree, "Cours perso%"));
	$info = $reqUser->fetch();
    if(!$info){
        return array();
    }
    return $info;
}

function getCours(PDO $bdd, int $idCours):array{
    $reqUser = $bdd->prepare("SELECT * FROM COURS WHERE idCours = ?");
	$reqUser->execute(array($idCours));
	$info = $reqUser->fetch();
	return $info;
    if(!$info){
        return array();
    }
    return $info;
}


function getRepresentation(PDO $bdd, int $idCours, string $usernameMoniteur, string $dateCours, float $heureDebut):array{
    $reqRepr = $bdd->prepare("SELECT * FROM REPRESENTATION NATURAL JOIN COURS WHERE idCours = ? AND usernameMoniteur = ? AND dateCours = ? AND heureDebutCours = ?");
	$reqRepr->execute(array($idCours,$usernameMoniteur,$dateCours,$heureDebut));
	$info = $reqRepr->fetch();
    if(!$info){
        return array();
    }
    return $info;
}
function getNbRestantCours(PDO $bdd, int $idCours, string $usernameMoniteur, string $dateCours, float $heureDebut):int{
    $representation = getRepresentation($bdd, $idCours, $usernameMoniteur, $dateCours, $heureDebut);

    $reqResrv = $bdd->prepare("SELECT * FROM RESERVATION WHERE idCours = ? AND usernameMoniteur = ? AND dateCours = ? AND heureDebutCours = ?");
	$reqResrv->execute(array($idCours,$usernameMoniteur,$dateCours,$heureDebut));
	$info = $reqResrv->rowCount();
    $nbRestant = $representation["nbMax"] - $info;
    if($nbRestant<0)
        $nbRestant = 0;
    return $nbRestant;
}

/**
 * Renvoie si une demande de cours existe pour un jour
 *
 * @param PDO la base de donnée
 * @param string username
 * @param string jour
 *
 * @return bool si la demande existe pour le jour donnée
 */
function getDemandeExistDay(PDO $bdd, string $username, string $day): bool
{
	$reqUser = $bdd->prepare("SELECT * FROM DEMANDECOURS WHERE usernameClient = ? AND dateCours = ?");
	$reqUser->execute(array($username, $day));
	return $reqUser->rowCount() >= 1;
}

/**
 * Renvoie une demande de cours
 *
 * @param PDO la base de donnée
 * @param string usernameClient
 * @param string jour
 * @param int idCours
 * @param float heureDebut
 *
 * @return array la demande de cours
 */
function getDemandeDeCours(PDO $bdd, string $username, string $day, int $idCours, float $heure): array
{
	$reqUser = $bdd->prepare("SELECT * FROM DEMANDECOURS WHERE usernameClient = ? AND dateCours = ? AND idCours = ? AND heureDebutCours = ?");
	$reqUser->execute(array($username, $day,$idCours, $heure));
	return $reqUser->fetch();
}


/**
 * get les moniteurs de la bd
 *
 * @param PDO la base de donnée
 *
 * @return array liste des moniteurs de la bd
 */
function getMoniteur(PDO $bdd): array
{
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
function getDispo(PDO $bdd, string $username, string $day, string $startTime): array
{
	$reqUser = $bdd->prepare("SELECT * FROM DISPONIBILITE WHERE usernameMoniteur = ? AND dateDispo = ? AND heureDebutDispo = ?");
	$reqUser->execute([$username, $day, $startTime]);
	$info = $reqUser->fetch();
    if(!$info){
        return array();
    }
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
function getDispoDay(PDO $bdd, string $username, string $day): array
{
	$reqUser = $bdd->prepare("SELECT * FROM DISPONIBILITE WHERE usernameMoniteur = ? AND dateDispo = ?");
	$reqUser->execute([$username, $day]);
	$info = $reqUser->fetchAll();
	return $info;
}

/**
 * Renvoie les représentation d'un moniteur pour la journée
 *
 * @param PDO la base de donnée, 
 * @param string usrname nom moniteur 
 * @param string $day date  
 *
 * @return array les représentation
 */
function getRepresentationDay(PDO $bdd, string $username, string $day): array
{
	$reqUser = $bdd->prepare("SELECT * FROM REPRESENTATION NATURAL JOIN COURS WHERE usernameMoniteur = ? AND dateCours = ?");
	$reqUser->execute([$username, $day]);
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
function existMail(PDO $bdd, string $mail): bool
{

	$reqMail = $bdd->prepare("SELECT * FROM PERSONNE WHERE mail = ?");
	$reqMail->execute(array($mail));
	return $reqMail->rowCount() >= 1;
}

/**
 * verifie l'existance du user de la bd
 *
 * @param PDO la base de donnée, 
 * @param string $user mail a vérifier 
 *
 * @return bool si l'user existe renvoie true, false sinon
 */
function existUsername(PDO $bdd, string $username): bool
{
	$reqMail = $bdd->prepare("SELECT * FROM PERSONNE WHERE username = ?");
	$reqMail->execute(array($username));
	return $reqMail->rowCount() >= 1;
}

function getCotisationsAnneeEnCours(PDO $bdd):array{
    $date = new DateTime();
    $date2 = new DateTime();

    if((int)$date->format("m")>=9){ //septembre
        $date2->add(DateInterval::createFromDateString('1 year'));
        $periode = $date->format("Y")."-".$date2->format("Y");
    }
    else{
        $date2->sub(DateInterval::createFromDateString('1 year'));
        $periode = $date2->format("Y")."-".$date->format("Y");
    }
    $reqCoti = $bdd->prepare("SELECT * FROM COTISATION WHERE periode=?");
	$reqCoti->execute(array($periode));
    return $reqCoti->fetchAll();
}

function insererCotisations(PDO $bdd):void{
    $date = new DateTime();
    $date2 = new DateTime();
    $date3 = new DateTime();

    if((int)$date->format("m")>=9){ //septembre
        $date2->add(DateInterval::createFromDateString('1 year'));
        $date3->sub(DateInterval::createFromDateString('1 year'));
        $periode = $date->format("Y")."-".$date2->format("Y");
        $lastPeriode = $date3->format("Y")."-".$date->format("Y");
    }
    else{
        $date2->sub(DateInterval::createFromDateString('1 year'));
        $date3->sub(DateInterval::createFromDateString('2 year'));
        $periode = $date2->format("Y")."-".$date->format("Y");
        $lastPeriode = $date3->format("Y")."-".$date2->format("Y");
    }


    $reqCoti = $bdd->prepare("SELECT * FROM COTISATION WHERE periode=?");
	$reqCoti->execute(array($periode));
    if($reqCoti->rowCount()<=0){
        $reqCoti->execute(array($lastPeriode));
        $anciennesCoti = $reqCoti->fetchAll();
        $reqInsert = $bdd->prepare("INSERT INTO COTISATION (nomCotisation, periode, prixCotisationAnnuelle) VALUES (?,?,?)");
        foreach($anciennesCoti as $cotisation){
            $reqInsert->execute(array($cotisation["nomCotisation"],$periode,$cotisation["prixCotisationAnnuelle"]));
        }
    }
}

function clientAPayerCotisation(PDO $bdd, string $username):bool{
    $date = new DateTime();
    $date2 = new DateTime();

    if((int)$date->format("m")>=9){ //septembre
        $date2->add(DateInterval::createFromDateString('1 year'));
        $periode = $date->format("Y")."-".$date2->format("Y");
    }
    else{
        $date2->sub(DateInterval::createFromDateString('1 year'));
        $periode = $date2->format("Y")."-".$date->format("Y");
    }
    $reqPayer = $bdd->prepare("SELECT * FROM PAYER WHERE usernameClient = ? AND periode=?");
	$reqPayer->execute(array($username,$periode));
	return $reqPayer->rowCount() >= 1;
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
function existDateDispoDay(PDO $bdd, string $username, string $day): bool
{
	$reqMail = $bdd->prepare("SELECT * FROM DISPONIBILITE WHERE usernameMoniteur = ? AND dateDispo = ?");
	$reqMail->execute(array($username, $day));
	return $reqMail->rowCount() >= 1;
}


/**
 * Renvoie si il y a un chevauchement entre deux période horaire
 *
 * @param string $heureDebut heure de début période 1 
 * @param string $heureFin heure de fin période 1   
 * @param string $heureDebut2 heure de début période 2
 * @param string $heureFin2 heure de fin période 2
 *
 * @return bool chevauchement
 */
function chevauchementHeure(string $heureDebut, string $heureFin, string $heureDebut2, string $heureFin2): bool
{
	$debut1 = strtotime($heureDebut);
	$fin1 = strtotime($heureFin);
	$debut2 = strtotime($heureDebut2);
	$fin2 = strtotime($heureFin2);

	return $debut1 <= $fin2 && $debut2 <= $fin1;
}

/**
 * Renvoie si la période 1 se trouve dans la période 2
 *
 * @param string $heureDebut heure de début période 1 
 * @param string $heureFin heure de fin période 1   
 * @param string $heureDebut2 heure de début période 2
 * @param string $heureFin2 heure de fin période 2
 *
 * @return bool chevauchement
 */
function heureDedans(string $heureDebut, string $heureFin, string $heureDebut2, string $heureFin2): bool
{
	$debut1 = strtotime($heureDebut);
	$fin1 = strtotime($heureFin);
	$debut2 = strtotime($heureDebut2);
	$fin2 = strtotime($heureFin2);

	return $debut1 <= $fin2 && $fin1 <= $fin2 && $debut2 <= $fin1 && $debut2 <= $debut1;
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
function existDateDispoConflit(PDO $bdd, string $username, string $day, string $heureDebut, string $heureFin, string $heureDebutEviter = ""):bool
{
	$dispoDay = getDispoDay($bdd, $username, $day);
	foreach ($dispoDay as $dispo) {
        $heureDebutDispo = convertFloatToTime($dispo["heureDebutDispo"]);
        $heureFinDispo = convertFloatToTime($dispo["heureFinDispo"]);
		if (($heureDebutEviter == "" || $heureDebutEviter != $heureDebutDispo) && chevauchementHeure($heureDebut, $heureFin, $heureDebutDispo, $heureFinDispo)) {
			echo $heureDebutEviter,"<br>", $heureDebutEviter, "<br>";
			return true;
		}
	}
	return false;
}

/**
 * Vérifie si le moniteur est disponible pour le cours donnée
 *
 * @param PDO la base de donnée, 
 * @param string usrname nom moniteur 
 * @param string $day date  
 * @param string $heureDebut heure de début période
 * @param string $heureFin heure de fin période
 *
 * @return int 1 - Si le moniteur est disponible // 0 - Si le moniteur a déjà un cours à ce moment // -1 - S'il n'est pas disponible (disponibilités)
 */
function moniteurEstDispo(PDO $bdd, string $username, string $day, string $heureDebut, string $heureFin):int
{
	$dispoDay = getDispoDay($bdd, $username, $day);
    $lesRepresentation = getRepresentationDay($bdd, $username, $day);
	foreach ($dispoDay as $dispo) {
        $heureDebutDispo = convertFloatToTime($dispo["heureDebutDispo"]);
        $heureFinDispo = convertFloatToTime($dispo["heureFinDispo"]);
		if (heureDedans($heureDebut, $heureFin, $heureDebutDispo, $heureFinDispo)) {
			return 1;
		}
	}
    foreach ($lesRepresentation as $representation) {
        $heureDebutRep = convertFloatToTime($representation["heureDebutCours"]);
        $heureFinRep = convertFloatToTime (($representation["heureDebutCours"] + $representation["duree"]));
        echo $heureDebut, " " ,$heureFin, "<br>",$heureDebutRep, " ", $heureFinRep;
		if (chevauchementHeure($heureDebut, $heureFin, $heureDebutRep, $heureFinRep)) {
			return 0;
		}
	}
	return -1;
}

/**
 * Transforme les heures au format "00:00" en float 0.0
 *
 * @param string heure au format "00:00", 
 *
 * @return float la version float
 */
function convertTimeToFloat(string $time): float
{
	$timeList = explode(':', $time);
	return (int) $timeList[0] + ($timeList[1] == "30" ? 0.5 : 0);
}

/**
 * Transforme les float 0.0 au format "00:00" 
 *
 * @param float temps 
 *
 * @return string heure au format "00:00"
 */
function convertFloatToTime(float $time): string
{
	$whole = (string) floor($time);
	$fraction = $time - $whole;
	if (strlen($whole) < 2) {
		$whole = str_pad($whole, 2, "0", STR_PAD_LEFT);
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
function getInfoByDate(PDO $bdd, string $client, string $date): array
{
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
function getAllInfoByMonth(PDO $bdd, string $client, string $month, string $year): array
{
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
 * get toutes les informations pour un mois donnée
 *
 * @param PDO la base de donnée, 
 * @param string $client nom client
 * @param string $month le mois 
 * @param string $year l'année 
 *
 * @return array liste information sur le mois 
 */
function getAllInfoByMonthMoniteur(PDO $bdd, string $client, string $month, string $year): array
{
	$reqUser = $bdd->prepare("SELECT heureDebutCours, activite, nomCours, day(dateCours) as day 
                              FROM RESERVATION 
                              NATURAL JOIN COURS 
                              NATURAL JOIN REPRESENTATION 
                              WHERE usernameMoniteur = ? 
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
function formatHeure(float $heureDecimal): string
{
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
function createPopUp(string $message, bool $success = true): void
{
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
function creerCalendrier(PDO $bdd, string $client): void
{
	$Days = 1;

	$date = new DateTime();

	// TODO: changer la date juste commenté cette instruction pour avoit la date de la journée
	// $date->setDate("2023","12","1");
	$date->setDate($date->format('Y'), $date->format('m'), 1);

	$nbJourDansMois = $date->format('t'); // 't' retourne le nombre de jours dans le mois
	$jourDebutMois = $date->format('N'); // Le jour de la semaine du 1er jour du mois (1 = lundi, 7 = dimanche)

	// header basique avec les jours
	echo '<table border="1" class="planningCal">';
	echo '<tr>';
	echo '<th>Lundi</th>';
	echo '<th>Mardi</th>';
	echo '<th>Mercredi</th>';
	echo '<th>Jeudi</th>';
	echo '<th>Vendredi</th>';
	echo '<th>Samedi</th>';
	echo '<th>Dimanche</th>';
	echo '</tr>';

    $role = getRole($bdd, $client);

    if($role === "admin" || $role === "moniteur"){
        $coursesByDay = getAllInfoByMonthMoniteur($bdd, $client, $date->format('m'), $date->format('Y'));
    }else {
        $coursesByDay = getAllInfoByMonth($bdd, $client, $date->format('m'), $date->format('Y'));
    }

    // print_r($coursesByDay);


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
                               " . "<p>Horaires : " . formatHeure($cours['heureDebutCours']) . "</p>" . "
                                <div class='event-details'>
                                    " . "<p>Horaires : " . formatHeure($cours['heureDebutCours']) . "</p>" . "
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
function getInfoCours(PDO $bdd, int $idcours, string $dateCours, float $heureDebutCours): array
{
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
function formatCours(string $date, float $heureDebut, float $dureeHeures): string
{
	// Convertir la date au format souhaité
	$dateFormatee = date("d F", strtotime($date));

	// Créer une fonction pour formater l'heure
	$formatterHeure = function ($heure) {
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
function updateMoniteur(PDO $bdd, string $oldUsername, string $username, string $prenom, string $nom, string $mail, string $role, array $info): array
{
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

/**
 * get les reservations de la bd
 *
 * @param PDO la base de donnée, 
 * @param int $niveau du cours
 *
 * @return array les poneys
 */
function getReserv(PDO $bdd, int $niveau): array
{
	$reqUser = $bdd->prepare("SELECT * FROM DEMANDECOURS NATURAL JOIN PONEY NATURAL JOIN COURS NATURAL JOIN NIVEAU where idNiveau <= ? ORDER BY dateCours DESC");
	$reqUser->execute([$niveau]);
	$info = $reqUser->fetchAll();
	return $info;
}




use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Inclure les fichiers de PHPMailer
require __DIR__ . '/../PHPMailer/src/Exception.php';
require __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../PHPMailer/src/SMTP.php';


/**
 * envoie un email au client
 *
 * @param string ..... info du client 
 * TODO
 *
 * @return bool true si le mail est envoyer, false sinon
 */
function mailClientDemandeCours($sendingEmail, $email, $username, $object, $dateDemandeCours, $heureCours, $dureeCours, $activiteDuCours):bool{
    $mail = new PHPMailer(true);
    try {
        // Paramètres du serveur
        $mail->SMTPDebug = 0;                      
        $mail->isSMTP();                           
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;                   
        $mail->Username = $sendingEmail; 
        // $mail->Password = $ligne;
        $mail->Password = "tnlfxcttheyncjyv";

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
        $mail->Port = 587;
        // $mail->SMTPDebug = 2; 
        $mail->SMTPOptions = [];

        // Destinataires
        $mail->setFrom($sendingEmail, 'SAE PONEY GRAND GALOP');
        $mail->addAddress($email);
        
        // Contenu
        // $mail->addEmbeddedImage('../assets/images/poney/flocon.jpg', 'image_cid');

        $mail->isHTML(true);            
        $mail->CharSet = 'UTF-8';           
        $mail->Subject = $object;
        $mail->Body = "
          <html>
              <head>
                  <style>
                      body {
                          font-family: Arial, sans-serif;
                          margin: 0;
                          padding: 0;
                          background-color: #f9f9f9;
                      }
                      .container {
                          max-width: 600px;
                          margin: 20px auto;
                          background: #ffffff;
                          border: 1px solid #ccc;
                          border-radius: 8px;
                          padding: 20px;
                          box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                      }
                      .header {
                          font-weight: bold;
                          font-size: 18px;
                          color: #333333;
                          margin-bottom: 10px;
                      }
                      .content {
                          font-size: 14px;
                          color: #555555;
                          line-height: 1.5;
                          margin-bottom: 20px;
                      }
                      .footer {
                          font-size: 12px;
                          color: #888888;
                          text-align: center;
                          margin-top: 20px;
                      }
                      .image-container {
                          text-align: center;
                          margin-bottom: 20px;
                      }
                      .image-container img {
                          max-width: 100%;
                          height: auto;
                          border-radius: 8px;
                      }
                  </style>
              </head>
              <body>
                  <div class='container'>
                      <div class='header'>
                          Votre demande de cours a bien été enregistrée !
                      </div>
                      <div class='content'>
                          <p>Bonjour $username,</p>
                          <p>
                              Votre demande de cours pour le <strong>".$dateDemandeCours."</strong> 
                              à <strong>".$heureCours."</strong> et durant <strong>".$dureeCours."</strong>h 
                              pour l'activité suivante : <strong>".$activiteDuCours."</strong>, 
                              a bien été prise en compte.
                          </p>
                          <p>
                              Vous recevrez un message lors de la validation de celle-ci.
                          </p>
                          <p>
                              Merci de nous avoir fait confiance. Nous restons à votre disposition
                              pour toute question supplémentaire.
                          </p>
                      </div>
  

                      <!-- <div class='image-container'>
                          <img src='https://via.placeholder.com/500x300?text=GRAND+GALOP' alt='GRAND GALOP Logo'>
                      </div> -->
                      <div class='footer'>
                          Cordialement,<br>
                          GRAND GALOP
                      </div>
                  </div>
              </body>
          </html>

        "; 
        $mail->AltBody = "Votre demande de contact à bien été envoyé\nJ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        // echo "<pre>";
        // print_r($e);
        // echo "</pre>";

        echo "Erreur lors de l'envoi du mail : ", $mail->ErrorInfo;

        return false;

    }
}




/**
 * envoie un email au client
 *
 * @param string ..... info du client 
 * TODO
 *
 * @return bool true si le mail est envoyer, false sinon
 */
function mailClientDemandeCoursConfirme( $sendingEmail, $email, $username, $object, $dateDemandeCours, $heureCours, $dureeCours, $activiteDuCours):bool{
    $mail = new PHPMailer(true);
    try {
        // Paramètres du serveur
        $mail->SMTPDebug = 0;                      
        $mail->isSMTP();                           
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;                   
        $mail->Username = $sendingEmail; 
        // $mail->Password = $ligne;
        $mail->Password = "tnlfxcttheyncjyv";

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
        $mail->Port = 587;
        // $mail->SMTPDebug = 2; 
        $mail->SMTPOptions = [];

        // Destinataires
        $mail->setFrom($sendingEmail, 'SAE PONEY GRAND GALOP');
        $mail->addAddress($email);
        
        // Contenu
        // $mail->addEmbeddedImage('../assets/images/poney/flocon.jpg', 'image_cid');

        $mail->isHTML(true);            
        $mail->CharSet = 'UTF-8';           
        $mail->Subject = $object;
        $mail->Body = "
                    <html>
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 0;
                            padding: 0;
                            background-color: #f9f9f9;
                        }
                        .container {
                            max-width: 600px;
                            margin: 20px auto;
                            background: #ffffff;
                            border: 1px solid #ccc;
                            border-radius: 8px;
                            padding: 20px;
                            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                        }
                        .header {
                            font-weight: bold;
                            font-size: 18px;
                            color: #333333;
                            margin-bottom: 10px;
                        }
                        .content {
                            font-size: 14px;
                            color: #555555;
                            line-height: 1.5;
                            margin-bottom: 20px;
                        }
                        .footer {
                            font-size: 12px;
                            color: #888888;
                            text-align: center;
                            margin-top: 20px;
                        }
                        .image-container {
                            text-align: center;
                            margin-bottom: 20px;
                        }
                        .image-container img {
                            max-width: 100%;
                            height: auto;
                            border-radius: 8px;
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            Votre demande de cours a été confirmée !
                        </div>
                        <div class='content'>
                            <p>Bonjour $username,</p>
                            <p>
                                Nous sommes ravis de vous informer que votre demande de cours pour le <strong>".$dateDemandeCours."</strong> 
                                à <strong>".$heureCours."</strong> et durant <strong>".$dureeCours."</strong>h 
                                pour l'activité suivante : <strong>".$activiteDuCours."</strong>, 
                                a été confirmée avec succès.
                            </p>
                            <p>
                                Nous vous remercions pour votre confiance et nous vous souhaitons une excellente expérience.
                            </p>
                            <p>
                                N'hésitez pas à nous contacter pour toute question ou information supplémentaire.
                            </p>
                        </div>

                        <!-- <div class='image-container'>
                            <img src='https://via.placeholder.com/500x300?text=GRAND+GALOP' alt='GRAND GALOP Logo'>
                        </div> -->
                        <div class='footer'>
                            Cordialement,<br>
                            GRAND GALOP
                        </div>
                    </div>
                </body>
            </html>

        "; 
        $mail->AltBody = "Votre demande de contact à bien été envoyé\nJ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        // echo "<pre>";
        print_r($e);
        echo "</pre>";

        echo "Erreur lors de l'envoi du mail : ", $mail->ErrorInfo;

        return false;

    }
}


/**
 * envoie un email au client
 *
 * @param string ..... info du client 
 * TODO
 *
 * @return bool true si le mail est envoyer, false sinon
 */
function mailMoniteurDemandeCoursConfirme($sendingEmail, $email, $moniteurName, $username, $object, $dateDemandeCours, $heureCours, $dureeCours, $activiteDuCours):bool{
    $mail = new PHPMailer(true);
    try {
        // Paramètres du serveur
        $mail->SMTPDebug = 0;                      
        $mail->isSMTP();                           
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;                   
        $mail->Username = $sendingEmail; 
        // $mail->Password = $ligne;
        $mail->Password = "tnlfxcttheyncjyv";

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
        $mail->Port = 587;
        // $mail->SMTPDebug = 2; 
        $mail->SMTPOptions = [];

        // Destinataires
        $mail->setFrom($sendingEmail, 'SAE PONEY GRAND GALOP');
        $mail->addAddress($email);
        
        // Contenu
        // $mail->addEmbeddedImage('../assets/images/poney/flocon.jpg', 'image_cid');

        $mail->isHTML(true);            
        $mail->CharSet = 'UTF-8';           
        $mail->Subject = $object;
        $mail->Body = "<html>
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 0;
                            padding: 0;
                            background-color: #f9f9f9;
                        }
                        .container {
                            max-width: 600px;
                            margin: 20px auto;
                            background: #ffffff;
                            border: 1px solid #ccc;
                            border-radius: 8px;
                            padding: 20px;
                            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                        }
                        .header {
                            font-weight: bold;
                            font-size: 18px;
                            color: #333333;
                            margin-bottom: 10px;
                        }
                        .content {
                            font-size: 14px;
                            color: #555555;
                            line-height: 1.5;
                            margin-bottom: 20px;
                        }
                        .footer {
                            font-size: 12px;
                            color: #888888;
                            text-align: center;
                            margin-top: 20px;
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            Une demande de cours a été confirmée !
                        </div>
                        <div class='content'>
                            <p>Bonjour $moniteurName,</p>
                            <p>
                                Une demande de cours a été confirmée et vous est assignée. Voici les détails :
                            </p>
                            <ul>
                                <li><strong>Date :</strong> ".$dateDemandeCours."</li>
                                <li><strong>Heure :</strong> ".$heureCours."</li>
                                <li><strong>Durée :</strong> ".$dureeCours." heures</li>
                                <li><strong>Activité :</strong> ".$activiteDuCours."</li>
                                <li><strong>Utilisateur :</strong> $username</li>
                            </ul>
                            <p>
                                Merci de bien vouloir vous préparer pour ce cours et de nous informer en cas de problème ou de question.
                            </p>
                        </div>
                        <div class='footer'>
                            Cordialement,<br>
                            GRAND GALOP
                        </div>
                    </div>
                </body>
            </html>


        "; 
        $mail->AltBody = "Votre demande de contact à bien été envoyé\nJ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        // echo "<pre>";
        // print_r($e);
        // echo "</pre>";

        // echo "Erreur lors de l'envoi du mail : ", $mail->ErrorInfo;

        return false;

    }
}



/**
 * Get le solde du client 
 * 
 * @param PDO $bdd base de donnée
 * @param string $client username client
 * 
 * @return int la valeur du solde du client
 * 
 */
function getSoldeClient(PDO $bdd, string $client): int
{
	$reqUser = $bdd->prepare("SELECT solde FROM CLIENT WHERE usernameClient = ?");
	$reqUser->execute([$client]);
	$info = $reqUser->fetch();
	return $info["solde"] ?? 0;
}

/**
 * mets a jour le solde du client 
 * 
 * @param PDO $bdd base de donnée
 * @param string $usernameClient username du client
 * @param int decrSolde le sole a soustraire
 * 
 * 
 * @return le solde du client actuelle, -1 s'il y a une erreur (le solde se decremente seulement si le final est au dessus de 0)
 */
function updateDecrSoldeCLient(PDO $bdd, string $usernameClient, int $decrSolde) : int{
    $soldeClient = getSoldeClient($bdd, $usernameClient);
    
    if(($soldeClient - $decrSolde) >= 0){
        try {
            // Préparer la requête sécurisée
            $sql = "UPDATE CLIENT SET solde = solde - $decrSolde WHERE usernameClient = :username";
            $stmt = $bdd->prepare($sql);
            $stmt->bindParam(':username', $usernameClient, PDO::PARAM_STR);
    
            // Exécuter la requête
            if ($stmt->execute()) {
                echo "Solde mis à jour avec succès.";
                return $soldeClient - $decrSolde;
            } 
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return -1;
        }
    }
    return -1;
}



// SELECT heureDebutCours, activite, nomCours, day(dateCours) as day 
//                               FROM RESERVATION 
//                               NATURAL JOIN COURS 
//                               NATURAL JOIN REPRESENTATION 
//                               WHERE usernameClient = "client1" 
//                               AND MONTH(dateCours) = "01" 
//                               AND YEAR(dateCours) = "2025";