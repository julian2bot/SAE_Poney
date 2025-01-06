<?php
require_once "../utils/connexionBD.php";
require_once "../utils/annexe.php";

estConnecte();
estAdmin();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration</title>
    <link rel="stylesheet" href="../assets/style/admin.css">
    <link rel="stylesheet" href="../assets/style/header.css">
    <link rel="stylesheet" href="../assets/style/form.css">
</head>
    <body style="position: relative;">
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


    <div class="creerPoney" id="creerPoney" style="display: none;">

        <section>
            <h2>creerPoney</h2>
            <p>Entrer vos compte pour vous connecter</p>
            <form method="POST" action="../utils/creerPoney.php" class="form">

                <label for="nomPoney">nom du Poney</label>
                <input type="text" name="nomPoney" id="nomPoney" placeholder="gerard" autocomplete="off" class="form-control-material">

                
                <label for="poidMax">le poid poney</label>
                <input type="number" name="poidMax" id="poidMax" placeholder="lourd" min="0" max="255" autocomplete="off" class="form-control-material">
                
                <label for="photo">photo (chemin acces)</label>
                <input type="text" name="photo" id="photo" placeholder="blabla.png" autocomplete="off" class="form-control-material">

                <label for="race">race</label>
                <input type="text" name="race" id="race" placeholder="licorned" autocomplete="off" class="form-control-material">


                <?php
                if(isset($_GET["erreurCreerPoney"])){
                    echo '<font color="red">'.$_GET["erreurCreerPoney"]."</font>";
                }
                ?>

                <button type="submit" class="btn" name="fromSignIn">
                    Creer poney
                </button>
            </form>
        </section>
        <img src="../assets/images/SignInImage.jpg" alt=""> 

    </div>






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
                
                
                <!-- liste des PONEYs -->
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
                <!-- <button class="add-btn" onclick="afficheCreerPoney()" id="page poney">Ajouter un Poney</button> -->
                <button class="add-btn" id="creation_poney">Ajouter un Poney</button>
                    
                <!-- liste des moniteurs -->
                <div class="list" style="overflow:scroll; max-height:500px;">
                    <h3>Liste des Moniteurs</h3>
                    <ul id="client-list">
                        <?php
                        
                        foreach (getMoniteur($bdd) as $moniteur) {
                            echo '<li>'. $moniteur["usernameMoniteur"].' <a href="../utils/removeMoniteur.php?id='.$moniteur["usernameMoniteur"].'" class="remove-btn">Retirer</a></li>';
                        }

                        ?>                
                    </ul>
                </div>
                <button class="add-btn" onclick="afficheCreerMoniteur()" id="page poney">Ajouter un Poney</button>

                <!-- liste des clients -->
                <div class="list" style="overflow:scroll; max-height:500px;">
                        <h3>Liste des Clients</h3>
                    <ul id="client-list">
                        <?php
                        
                        foreach (getClient($bdd) as $client) {
                            echo '<li>'. $client["usernameClient"].' <a href="../utils/removeClient.php?id='.$client["usernameClient"].'" class="remove-btn">Retirer</a></li>';
                        }

                        ?>                
                    </ul>
                </div>

            </section>
        </main>
        <script src="../assets/script/afficherAdmin.js"></script>
    </div>
    </body>

    <?php
    // ouvrir le login ou signin s'il y a une erreur 
    if(isset($_GET["erreurCreerPoney"])){
        // print_r($_GET);
        echo '<script type="text/javascript">
                    afficheCreerPoney();
              </script>';
    }
    ?>
</html>

