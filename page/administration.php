<?php
require_once "../utils/connexionBD.php";
require_once "../utils/annexe.php";
if(!isset($_SESSION["connecte"]) OR $_SESSION["connecte"]["role"] !== "admin"){

    header("Location: ../");

}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Cas d'utilisation</title>
    <link rel="stylesheet" href="../assets/style/admin.css">
    <link rel="stylesheet" href="../assets/style/header.css">
</head>
    <body>
    <header class="pageAdmin">
        <nav>
            <ul>
                <li>
                    <a href="moniteur.php">
                        retour
                    </a>
                </li>
            
            </ul>
        </nav>
    </header>



        <div class="admin-container">
            <!-- Section des cas d'utilisation -->
            <header>
            <h1>Administration</h1>
            <p>Gestion des tâches administratives</p>
            </header>
            <main>
            
            <!-- Section des listes -->
            <section class="lists-section">
                <h2>Gestion des Poneys, Élèves et Clients</h2>
                <div class="list">
                <h3>Liste des Poneys</h3>
                
                <ul id="pony-list">
                    <!-- <li>Poney 1 <button class="remove-btn">Retirer</button></li> -->
                    <?php
                    // echo '<pre>';
                    // print_r(getPoney($bdd));
                    // echo '</pre>';
                    
                    foreach (getPoney($bdd) as $poney) {
                        echo '<li>'.$poney["nomPoney"].' <a href="../utils/removePoney.php?idPoney='.$poney["idPoney"].'" class="remove-btn">Retirer</a></li>';
                    }
                    
                    ?>
                </ul>
                <button class="add-btn">Ajouter un Poney</button>
                </div>

                <div class="list">
                <h3>Liste des Élèves</h3>
                <ul id="student-list">
                    <li>Élève 1 <button class="remove-btn">Retirer</button></li>
                    <li>Élève 2 <button class="remove-btn">Retirer</button></li>
                </ul>
                <button class="add-btn">Ajouter un Élève</button>
                </div>

                <div class="list">
                <h3>Liste des Clients</h3>
                <ul id="client-list">
                    <li>Client 1 <button class="remove-btn">Retirer</button></li>
                    <li>Client 2 <button class="remove-btn">Retirer</button></li>
                </ul>
                <button class="add-btn">Ajouter un Client</button>
                </div>
            </section>
            </main>
        </div>
    </body>
</html>

