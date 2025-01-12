<?php
require_once "../utils/BDD/connexionBD.php";
require_once "../utils/annexe.php";

estConnecte();
estMoniteur();


// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration</title>
    <link rel="stylesheet" href="../assets/style/admin.css">
    <link rel="stylesheet" href="../assets/style/header.css">
    <link rel="stylesheet" href="../assets/style/styleSousPage.css">
    <script src="../assets/script/popUpGestionErr.js"></script>
</head>
    <body style="position: relative;">
    <header class="pageAdmin">
        <nav>
            <ul>
                <li>
                    <a href="moniteur.php">
                        Retour
                    </a>
                </li>
            
            </ul>
        </nav>
    </header>



    <div class="admin-container">
        <!-- Section des cas d'utilisation -->
        <header>
            <h1>Reservation</h1>
            <p>Gestion des reservations de client</p>
        </header>

        <main>
        
        <!-- Section des listes -->
            <section class="lists-section">
                
                
                
                <!-- liste des PONEYs -->
                <div class="list" style="overflow:scroll; max-height:500px;">
                    <h3 id="reservation">Les reservations actuelles</h3>
                    
                    <ul id="reserv-list">
                        <?php
                        // echo "<pre>";
                        // print_r(getReserv($bdd,2));
                        // echo "</pre>";
                        // foreach (getReserv($bdd,2) as $reserv) {
                        foreach (getReserv($bdd, $_SESSION["connecte"]["info"]["niveau"]) as $reserv) {
                            echo '<li> Demande de ' . 
                                $reserv["usernameClient"].", Cours le ".
                                $reserv["dateCours"]." à ".
                                convertFloatToTime($reserv["heureDebutCours"]).", avec le poney ".
                                $reserv["nomPoney"].", niveau : ".
                                $reserv["nomNiveau"]
                            
                            .'';
                            echo "<div class = 'boutons'>";
                            echo '<a href="../utils/moniteur/cours/accepterReserv.php?userClient='.$reserv["usernameClient"]."&idCours=".$reserv["idCours"]."&dateCours=".$reserv["dateCours"]."&heureDebutCours=".$reserv["heureDebutCours"]."&usernameMoniteur=".$_SESSION["connecte"]["username"].'" class="remove-btn">Accepter</a>';
                            echo "</div>";
                            echo "</li>";
                        }
                        
                        ?>
                    </ul>
                </div>
                

            </section>
        </main>
    </div>
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

