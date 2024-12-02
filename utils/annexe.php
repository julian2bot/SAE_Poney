<?php


function CrypterMdp($bdd){

    $sql = "SELECT username, mdp FROM personne";
    $stmt = $bdd->query($sql);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $username = $row['username'];
        $mdp = $row['mdp'];

        // Étape 2 : Vérifier si le mot de passe est déjà crypté
            // Étape 3 : Crypter le mot de passe avec SHA1
            $mdpCrypte = sha1($mdp);

            // Étape 4 : Mettre à jour la base de données
            $updateSql = "UPDATE personne SET mdp = :mdp WHERE username = :username";
            $updateStmt = $bdd->prepare($updateSql);
            $updateStmt->execute([':mdp' => $mdpCrypte, ':username' => $username]);

            echo "Mot de passe de l'utilisateur $username a été crypté avec succès.<br>";
    }
}


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