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

    $sql = "SELECT username, mdp FROM personne";
    $stmt = $bdd->query($sql);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $username = $row['username'];
        $mdp = $row['mdp'];

            $mdpCrypte = sha1($mdp);

            $updateSql = "UPDATE personne SET mdp = :mdp WHERE username = :username";
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



// function creerCalendrier(){
//     $Days = 1;
    
//     $date = new DateTime();
//     echo $date->format('Y-m-d H:i:s');
//     // $date->setDate(2025, 5, 1); 
//     // Nombre de jours dans le mois
//     $nbJourDansMois = $date->format('t'); // 't' retourne le nombre de jours dans le mois
//     $jourDebutMois = $date->format('N')+1; // Le jour de la semaine du 1er jour du mois (1 = lundi, 7 = dimanche)
    
//     // header basique avec les jours
//     echo '<table border="1">';
//     echo '<tr>';
//     echo '<th>Lundi</th>';
//     echo '<th>Mardi</th>';
//     echo '<th>Mercredi</th>';
//     echo '<th>Jeudi</th>';
//     echo '<th>Vendredi</th>';
//     echo '<th>Samedi</th>';
//     echo '<th>Dimanche</th>';
//     echo '</tr>';
    
//     for ($i=0; $i < 6 ; $i++) { 
//         echo '<tr>';
        
        
//         for($j=1; $j < 8; $j++) { 

//             // if( $j > $jourDebutMois ){
//             if(($j >= $jourDebutMois && $i===0) OR( $i !== 0 && $Days <= $nbJourDansMois)){
//                 echo "<td>$Days</td>";
//                 $Days++;
//             }else{
//                 echo "<td></td>";
//             }
            
//         }
        
//         echo '</tr>';
        
//     }
// }


function creerCalendrier(){
    $Days = 1;
    
    $date = new DateTime();
    $date->setDate($date->format('Y'), $date->format('m')+1, 1);
    echo $date->format('Y-m-d H:i:s') . '<br>';

    // Nombre de jours dans le mois
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
    
    for ($i=0; $i < 6 ; $i++) { 
        echo '<tr>';
        
        
        for($j=1; $j < 8;$j++) { 

            // if( $j > $jourDebutMois ){
            if(($j >= $jourDebutMois && $i===0) OR ($i !== 0 && $Days <= $nbJourDansMois)){
                echo "<td class='styled-cell'>$Days
                    <div class='event-box'>
                        <!-- titre / heure de cours de base -->
                        <h2 class='event-title'>PONEY 🐴</h2>
                        <p>Horaires : XX:XX</p>
                        <!-- les details -->
                        <div class='event-details'>
                            <p>Lieu : XX rue du 16</p>
                            <p>Modalités particudalités</p>
                        </div>
                    </div>
                </td>";
                $Days++;
            }else{
                echo "<td></td>";
            }
            if ($Days > $nbJourDansMois) {
                break;
            }
            
        }
        echo '</tr>';
        
        if ($Days > $nbJourDansMois) {
            break;
        }
    }
    echo '</table>';

}