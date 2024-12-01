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