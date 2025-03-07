<?php
// code pour modifier le poney dans la page admin

require_once __DIR__."/../../BDD/connexionBD.php";
require_once __DIR__."/../../annexe.php";
estAdmin();


if($_SESSION["connecte"]["role"] === "admin" && 
    isset($_POST["identifiant"]) &&
    isset($_POST["nomPoney"]) &&
    isset($_POST["poidMax"]) && 
    // isset($_POST["photo"]) &&

    isset($_POST["race"])){
    // requete insert exemple:
    if(getRaceExist($bdd, $_POST["race"])){
        $targetDir = __DIR__."/../../../assets/images/poney/";
        
        
        // $replace = [";","\n","\r","\r\n", " ", "-" ];
        $nameImage = getPoneyById($bdd, $_POST["identifiant"])["photo"];
        echo $nameImage."<br>";

        echo "<pre>";
        print_r(getPoneyById($bdd, $_POST["identifiant"]));
        echo "</pre>";


        if(isset($_FILES["photo"])){
            $nameImageTime = new DateTime();
            $nameImageFormat = $nameImageTime->format("siHmY");
            
            $nameImage = mb_substr($_SESSION["connecte"]["username"].$nameImageFormat, 0, 24).".png";
    
    
            $fileName = basename($nameImage); 
            $targetFilePath = $targetDir . $fileName; 
            echo $targetFilePath.' <br>';
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            // Vérifiez si un fichier a été uploadé
            if (isset($_FILES["photo"]["tmp_name"]) && is_uploaded_file($_FILES["photo"]["tmp_name"])) {
                $fileType = strtolower(pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION));

                // Vérifiez si le type de fichier est autorisé
                $allowedTypes = ["jpg", "jpeg", "png", "gif"];
                if (in_array($fileType, $allowedTypes)) {
                    // Déplacez le fichier téléchargé vers le répertoire cible
                    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)) {
                        echo "Fichier téléchargé avec succès : " . $targetFilePath;
                    } else {
                        echo "Erreur lors du téléchargement du fichier.";
                    }
                } else {
                    echo "Type de fichier non autorisé. Formats acceptés : " . implode(", ", $allowedTypes);
                }
            } else {
                echo "Aucun fichier téléchargé.";
            }


            // $allowedTypes = ["jpg", "jpeg", "png", "gif"];
            // $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        }
        echo $nameImage."<br>";

        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Préparer la requête avec des ? pour les paramètres
        // PARTIE USER
        $updateSql = "UPDATE PONEY 
                        SET nomPoney = ?,
                            poidsMax = ?, 
                            photo = ?, 
                            nomRace = ? 
                        WHERE idPoney = ?";
    
        $updateStmt = $bdd->prepare($updateSql);
        
        // Exécuter la requête avec les paramètres dans le bon ordre
        $result = $updateStmt->execute([
            $_POST["nomPoney"], 
            $_POST["poidMax"], 
            $nameImage,
            $_POST["race"], 
            $_POST["identifiant"]]
        );
    
        // Vérifier le résultat
        if ($result) {
            echo "Mise à jour réussie<br>";
        } else {
            $errorInfo = $updateStmt->errorInfo();
            echo "Erreur SQL : " . $errorInfo[2];
        }

        $_SESSION["erreur"] = [];
        createPopUp("Poney modifié avec succès");
    }        

    else{
        $erreur = "La race du poney n'existe pas";
        $_SESSION["erreur"] = [];
        $_SESSION["erreur"]["identifiant"] = $_POST["identifiant"];
        $_SESSION["erreur"]["nomPoney"] = $_POST["nomPoney"];
        $_SESSION["erreur"]["poidMax"] = $_POST["poidMax"];
        $_SESSION["erreur"]["photo"] = $_POST["photo"];
        $_SESSION["erreur"]["race"] = $_POST["race"];
        createPopUp($erreur,false);
        header("Location: ../../../page/administration.php#Moniteurs");
        exit;

    }
}

header("Location: ../../../page/administration.php#Moniteurs");
exit;