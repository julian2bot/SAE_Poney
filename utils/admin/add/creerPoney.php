<?php
// code pour creer un moniteur et l'ajouter a la bd

require_once __DIR__."/../../BDD/connexionBD.php";
require_once __DIR__."/../../annexe.php";
estAdmin();
print_r($_FILES);
print_r($_POST);

if($_SESSION["connecte"]["role"] === "admin" && 
    isset($_POST["nomPoney"]) &&
    isset($_POST["poidMax"]) && 
    isset($_FILES["photo"]) &&
    // isset($_POST["photo"]) &&
    isset($_POST["race"])){
        
    // requete insert exemple:
    if(getRaceExist($bdd, $_POST["race"])){
        $targetDir = __DIR__."/../../../assets/images/poney/";
        
        
        $replace = [";","\n","\r","\r\n", " ", "-" ];
        
        $nameImage = str_replace($replace,"_", $_FILES["photo"]["name"] ) ;
        $nameImage = mb_substr($nameImage, 0, 25).".png";

        $fileName = basename($nameImage); 
        $targetFilePath = $targetDir . $fileName; 
        
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        $allowedTypes = ["jpg", "jpeg", "png", "gif"];
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        if (in_array($fileType, $allowedTypes)) {
            // Déplace le fichier téléchargé vers le dossier cible
            if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)) {
                // not goood
                echo 'not goood';
                createPopUp("Probleme import de l'image", false);
            }
        }    
        else{
            createPopUp("Probleme import de l'image", false);
        }
        // echo mb_substr($_FILES["photo"]["name"], 0, 28);

        $insertmbr = $bdd->prepare("INSERT INTO PONEY (idPoney, nomPoney, poidsMax, photo, nomRace) VALUES(?, ?, ?, ?, ?)");
        $insertmbr->execute(array(
            getIdMax($bdd, "idPoney", "PONEY")[0] + 1,
            $_POST["nomPoney"],
            $_POST["poidMax"],
            $nameImage ,
            $_POST["race"]
        ));    
        $_SESSION["erreur"] = [];
        createPopUp("Poney ajouté avec succès");
    }
    else{
        $erreur = "La race du poney n'existe pas";
        $_SESSION["erreur"] = [];
        $_SESSION["erreur"]["nomPoney"] = $_POST["nomPoney"];
        $_SESSION["erreur"]["poidMax"] = $_POST["poidMax"];
        $_SESSION["erreur"]["photo"] = $_POST["photo"];
        $_SESSION["erreur"]["race"] = $_POST["race"];
        createPopUp($erreur, false);
        header("Location: ../../../page/administration.php?erreurCreerPoney=$erreur#Poney");
        exit;

    }
}

header("Location: ../../../page/administration.php#Poney");
exit;






