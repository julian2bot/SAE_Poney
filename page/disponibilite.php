<?php
require_once "../utils/BDD/connexionBD.php";
require_once "../utils/annexe.php";

estConnecte();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grand Galop</title>
    <link rel="stylesheet" href="../assets/style/style.css">
    <link rel="stylesheet" href="../assets/style/styleSousPage.css">
    <link rel="stylesheet" href="../assets/style/reservation.css">
    <link rel="stylesheet" href="../assets/style/versionTelSousPage.css">
    <script src="../assets/script/popUpGestionErr.js"></script>
</head> 
    <body>
        <header>
            <h1>GRAND GALOP</h1>
            <h2>Ajouter une disponibilité</h2>
            <nav class="navDispo">
            <ul>
                <li>
                    <a href="moniteur.php">Retour</a>
                </li>
            </ul>
        </nav>
        </header>
        
        <main class="container">

            <section class="gauche-section disponible">
                <form method="POST" action="../utils/moniteur/add/ajoutDisponibilite.php">
                    <?php
                        if(isset($_GET["date"])){
                            $date = new DateTime();
                            $resultMin = $date->format('Y-m-d');
                            $date = date_create_from_format("Y-m-d",$_GET["date"]);
                            $result = $date->format('Y-m-d');
                            if ($result < $resultMin){
                                $result = $resultMin;
                            }
                        }
                        else{
                            $date = new DateTime();
                            $result = $date->format('Y-m-d');
                            $resultMin = $date->format('Y-m-d');
                        }
                        echo "<input class='styled-input' type='date' value=$result min=$resultMin name='dateDispo' id='dateDispo' required>"
                    ?>
                    <input class="styled-input" type="time" min="01:00" max="23:00" step="1800" name="heureDebut" id="heureDebut" required>
                    <input class="styled-input" type="time" min="01:00" max="23:00" step="1800" name="heureFin" id="heureFin" required>
                    <input class="styled-input" type="submit" value="Ajouter">
                </form>
            </section>
            
            <section class="droite-section disponible">

                <img src="../assets/images/cheval2.png" alt="cheval">

            </section>

        </main>
    </body>
    <?php
        if(isset($_SESSION["popUp"])){
            echo "<script type='text/javascript'>
                    showPopUp(\"".$_SESSION["popUp"]["message"]."\",".($_SESSION["popUp"]["success"] ? "true" : "false").");
                </script>";
            unset($_SESSION["popUp"]);
        }
    ?>
    
</html>
