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
    $reqUser = $bdd->prepare("SELECT * FROM MONITEUR NATURAL JOIN PERSONNE WHERE username = ? and usernameMoniteur = ?");
    $reqUser->execute(array($username,$username));
    $userExist = $reqUser->rowCount();
    if($userExist == 1)
    {
        $info = $reqUser->fetch();
        return array(
            "salaire" => $info["salaire"], 
            "isAdmin" => $info["isAdmin"] 
        ); 
    }
    else{
        $reqUser = $bdd->prepare("SELECT * FROM CLIENT NATURAL JOIN PERSONNE WHERE username = ? and usernameClient = ?");
        $reqUser->execute(array($username,$username));
        $userExist = $reqUser->rowCount();
        if($userExist == 1)
        {
            $info=$reqUser->fetch();   
            return array(
                "dateInscription" => $info["dateInscription"], 
                "poid" => $info["poidsClient"], 
                "solde" => $info["solde"]
            ); 
        }                
    }
    return array() ;  
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


function getIdMax($bdd, $idNom, $table){
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
