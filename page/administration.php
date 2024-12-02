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
    <title>Administration</title>
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
                
                <h2>Gestion des Poneys & Clients</h2>
                
                
                <!-- PONEY -->
                <div class="list" style="overflow:scroll; max-height:500px;">
                    <h3>Liste des Poneys</h3>
                    
                    <ul id="pony-list">
                        <?php
                        
                            foreach (getPoney($bdd) as $poney) {
                                echo '<li>'.$poney["nomPoney"].' <a href="../utils/removePoney.php?idPoney='.$poney["idPoney"].'" class="remove-btn">Retirer</a></li>';
                            }

                        ?>
                    </ul>
                </div>
                <button class="add-btn">Ajouter un Poney</button>

                
                <div class="list" style="overflow:scroll; max-height:500px;">
                <h3>Liste des Clients</h3>
                <ul id="client-list">
                    <?php
                    
                    foreach (getClient($bdd) as $client) {
                        echo '<li>'. $client["usernameClient"].' <a href="../utils/removeClient.php?id='.$client["usernameClient"].'" class="remove-btn">Retirer</a></li>';
                    }

                    ?>
                
                    <li>Client 2 <button class="remove-btn">Retirer</button></li>
                </ul>
            </div>
            </section>
            </main>
        </div>
    </body>
</html>

