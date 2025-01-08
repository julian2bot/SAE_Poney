<?php
require_once "../utils/connexionBD.php";
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
    <script src="../assets/script/popUpGestionErr.js"></script>
</head> 
    <body>
        <header>
            <h1>GRAND GALOP</h1>
            <nav>
            <ul>
                <li>
                    <a href="moniteur.php">Retour</a>
                </li>
            </ul>
        </nav>
        </header>
        
        <main class="container">

            <section class="gauche-section disponible">
                <form method="POST" action="../utils/ajoutDisponibilite.php">
                    <?php
                        $date = new DateTime();
                        $result = $date->format('Y-m-d');
                        echo "<input type='date' value=$result min=$result name='dateDispo' id='dateDispo' required>"
                    ?>
                    <input type="time" min="01:00" max="23:00" step="1800" name="heureDebut" id="heureDebut" required>
                    <input type="time" min="01:00" max="23:00" step="1800" name="heureFin" id="heureFin" required>
                    <input type="submit" value="Ajouter">
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
