<?php
require_once "../utils/connexionBD.php";
require_once "../utils/annexe.php";

estConnecte();

if( !isset($_GET["idcours"]) AND !isset($_GET["dateCours"]) AND !isset($_GET["heureCours"])){
    header('Location: ../');
    exit;
}


$infoDuCours = getInfoCours($bdd, $_GET["idcours"], $_GET["dateCours"], $_GET["heureCours"]);



// echo "<pre>";
// print_r($infoDuCours);
// echo "</pre>";



?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grand Galop</title>
    <link rel="stylesheet" href="../assets/style/style.css">
    <link rel="stylesheet" href="../assets/style/reservation.css">
</head>
    <body>
        <header>
            <h1>GRAND GALOP</h1>
            <nav>
            <ul>
                <li>
                    <a href="moniteur.php" >
                        retour
                    </a>
                </li>
            
            </ul>
        </nav>
        </header>
        
        <main class="container">

            <section class="gauche-section-none">
                <h2><?php echo $infoDuCours["nomCours"]?></h2>
                <ul>
                    <li>avec le prof : <?php echo $infoDuCours["usernameMoniteur"]?> </li>
                    <li> A <?php echo $infoDuCours["prix"] ?> €</li>
                    <li><?php echo formatCours($infoDuCours["dateCours"], $infoDuCours["heureDebutCours"], $infoDuCours["duree"])?></li>
                    <li>Place Restant XX/<?php  echo $infoDuCours["nbMax"]?></li>
                </ul>
            </section>
            
            <section class="droite-section">

                <form action="../utils/reservationCours.php" method="post">
                    <input type="hidden" required id="idCours" name="idCours"  value="<?php echo $_GET["idcours"]?>" />
                    <input type="hidden" required id="usernameMoniteur" name="usernameMoniteur"  value="<?php echo $infoDuCours["usernameMoniteur"]?>" />
                    <input type="hidden" required id="dateCours" name="dateCours"  value="<?php echo $infoDuCours["dateCours"]?>" />
                    <input type="hidden" required id="heureDebutCours" name="heureDebutCours"  value="<?php echo $infoDuCours["heureDebutCours"]?>" />
                    <input type="hidden" required id="userclient" name="userclient"  value="<?php echo $_SESSION["connecte"]["username"]?>" />

                    

                    <div class="container-carrousel-poney">
                        <?php 
                            
                            foreach (getPoney($bdd) as $poney) {
                                echo "<div class='poney-item'>
                                        <input style='display:none;' type='radio' required id='poney{$poney["idPoney"]}' name='poneySelectionne' value='{$poney["idPoney"]}'>
                                        <label for='poney{$poney["idPoney"]}'>
                                            <img src='../assets/images/poney/{$poney["photo"]}' alt='Poney {$poney["nomPoney"]}'>
                                        </label>
                                    </div>";                            
                            }
                            

                        ?>
                    </div>

                    <button type="submit">Reserver</button>

                </form>

            </section>

        </main>
    </body>

</html>
