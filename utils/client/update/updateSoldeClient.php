<?php
require_once __DIR__."/../../BDD/connexionBD.php";

if (!isset($_POST['username'])) {
    echo "Nom d'utilisateur manquant.";
    exit;
}

$username = $_POST['username'];

try {
    // Préparer la requête sécurisée
    $sql = "UPDATE CLIENT SET solde = solde + 100 WHERE usernameClient = :username";
    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);

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
