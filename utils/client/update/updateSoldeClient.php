<?php
require_once __DIR__."/../../BDD/connexionBD.php";

if (!isset($_POST['username'])) {
    echo "Nom d'utilisateur manquant.";
    exit;
}

$username = $_POST['username'];

try {
    // Préparer la requête sécurisée
    $result= updateAddSoldeCLient($bdd,$username,100);

    // Exécuter la requête
    if ($stmt->execute()) {
        
        echo "Solde mis à jour avec succès.";
    } else {
        echo "Erreur lors de la mise à jour du solde.";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
