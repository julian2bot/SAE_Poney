<?php
require_once "../utils/connexionBD.php";
require_once "../utils/annexe.php";
if(!isset($_SESSION["connecte"]) OR $_SESSION["connecte"]["role"] !== "admin"){

    header("Location: ../");
    exit;

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

                <img src="../assets/images/SignInImage.jpg" alt=""> 
                <section>
                    <h2>creerPoney</h2>
                    <p>Entrer vos compte pour vous connecter</p>
                    <form method="POST" action="../utils/creerPoney.php" class="form">

                        <label for="nomPoney">nom du Poney</label>
                        <input type="text" name="nomPoney" id="nomPoney" placeholder="gerard" autocomplete="off" class="form-control-material">

                        
                        <label for="poidMax">le poid poney</label>
                        <input type="number" name="poidMax" id="poidMax" placeholder="lourd" autocomplete="off" class="form-control-material">
                        
                        <label for="photo">photo (chemin acces)</label>
                        <input type="text" name="photo" id="photo" placeholder="blabla.png" autocomplete="off" class="form-control-material">

                        <label for="race">race</label>
                        <input type="text" name="race" id="race" placeholder="licorned" autocomplete="off" class="form-control-material">

                        <!-- <?php
                        echo "<pre>";
                        print_r( getIdMax($bdd, "idPoney", "PONEY")); 
                        echo "</.pre>";
                        ?> -->
<!--    
nomPoney
poidsMax
photo
nomRace 
-->

                        <?php
                        if(isset($_GET["erreurCreerPoney"])){
                            echo '<font color="red">'.$_GET["erreurSignIn"]."</font>";
                        }
                        ?>

                        <button type="submit" class="btn" name="fromSignIn">
                            creer poney
                        </button>
                    </form>
                </section>

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

                <button class="add-btn" onclick="afficheCreerPoney()" id="page poney">Ajouter un Poney</button>

                
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
</html>

