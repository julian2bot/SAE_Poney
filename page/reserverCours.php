<?php
require_once "../utils/BDD/connexionBD.php";
require_once "../utils/annexe.php";

estConnecte();

if( !clientAPayerCotisation($bdd, $_SESSION["connecte"]["username"])){
    createPopUp("Vous devez payer la cotisation annuelle avant de pouvoir vous inscrire au cours",false);
    header('Location: ../');
    exit;
}

if( !isset($_GET["idcours"]) AND !isset($_GET["dateCours"]) AND !isset($_GET["heureCours"])){
    header('Location: ../');
    exit;
}


$infoDuCours = getInfoCours($bdd, $_GET["idcours"], $_GET["dateCours"], $_GET["heureCours"]);

$placesRestantes = getNbRestantCours($bdd,$infoDuCours["idCours"],$infoDuCours["usernameMoniteur"],$infoDuCours["dateCours"],$infoDuCours["heureDebutCours"]);

$restePlace = $placesRestantes>=1;

// echo "<pre>";
// print_r($infoDuCours);
// echo "</pre>";

$aReserve = existReservation($bdd,$infoDuCours["usernameMoniteur"],(int)$infoDuCours["idCours"], $infoDuCours["dateCours"],$infoDuCours["heureDebutCours"],$_SESSION["connecte"]["username"])

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grand Galop</title>
    <link rel="stylesheet" href="../assets/style/style.css">
    <link rel="stylesheet" href="../assets/style/reservation.css">
    <link rel="stylesheet" href="../assets/style/versionTelSousPage.css">
    <link rel="stylesheet" href="../assets/style/popUp.css">
</head>
    <body>
        <header>
            <h1>GRAND GALOP</h1>
            <?php
            if($aReserve){
                echo "<div id='cotisationNonPayer'>";
                echo "<div>";
                echo "<img src='../assets/images/warning.png' alt='warning'>";
                echo "<p>Vous avez déjà réservé ce cours.</p>";
                echo "<form action='../utils/client/cours/annulationReserv.php' method='post' class='formReserv'>";
                echo "<input type='hidden' required id='idCours' name='idCours'  value='$_GET[idcours]'/>";
                echo "<input type='hidden' required id='usernameMoniteur' name='usernameMoniteur' value='$infoDuCours[usernameMoniteur]'/>";
                echo "<input type='hidden' required id='dateCours' name='dateCours' value='$infoDuCours[dateCours]'/>";
                echo "<input type='hidden' required id='heureDebutCours' name='heureDebutCours' value='$infoDuCours[heureDebutCours]'/>";
                echo "<input type='hidden' required id='userclient' name='userclient'  value='".$_SESSION["connecte"]["username"]."'/>";
                echo "<input type='submit' value='Annuler la réservation'>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
            }
            else if(! $restePlace){
                echo "<div id='cotisationNonPayer'>";
                echo "<div>";
                echo "<img src='../assets/images/warning.png' alt='warning'>";
                echo "<p>Il n'y a plus de place pour ce cours, vous pouvez demander un cours similaire avec l'option pour demander un cours.</p>";
                echo "<a href='./demandeCours.php'>Demander un cours</a>";
                echo "</div>";
                echo "</div>";
            }
            
            ?>
            
            <nav>
            <ul>
                <li>
                    <a href="moniteur.php" >
                        Retour
                    </a>
                </li>
            
            </ul>

        </nav>
        </header>
        
        <main class="container">

            <section class="gauche-section-none">
                <h2><?php echo $infoDuCours["nomCours"]?></h2>
                <ul>
                    <li>Avec le prof : <?php echo $infoDuCours["usernameMoniteur"]?> </li>
                    <li>A <?php echo $infoDuCours["prix"] ?> €</li>
                    <li><?php echo formatCours($infoDuCours["dateCours"], $infoDuCours["heureDebutCours"], $infoDuCours["duree"])?></li>
                    <li>Places Restante :<?php  echo $placesRestantes?></li>
                </ul>
            </section>
            
            <section class="droite-section reserverCoursDroite">

                <form action="../utils/client/cours/reservationCours.php" method="post" class="formReserv">
                    <input type="hidden" required id="idCours" name="idCours"  value="<?php echo $_GET["idcours"]?>" />
                    <input type="hidden" required id="usernameMoniteur" name="usernameMoniteur"  value="<?php echo $infoDuCours["usernameMoniteur"]?>" />
                    <input type="hidden" required id="dateCours" name="dateCours"  value="<?php echo $infoDuCours["dateCours"]?>" />
                    <input type="hidden" required id="heureDebutCours" name="heureDebutCours"  value="<?php echo $infoDuCours["heureDebutCours"]?>" />
                    <input type="hidden" required id="userclient" name="userclient"  value="<?php echo $_SESSION["connecte"]["username"]?>" />
                    <input type="hidden" required id="prix" name="prix"  value="<?php echo $infoDuCours["prix"] ?>" />

                    

                    <div class="container-carrousel-poney" id="carrousel">
                        <?php foreach (getPoney($bdd) as $poney): ?>
                            <div class="poney-item">
                                <input type="radio" required id="poney<?php echo $poney['idPoney']; ?>" name="poneySelectionne" value="<?php echo $poney['idPoney']; ?>">
                                <label for="poney<?php echo $poney['idPoney']; ?>">
                                    <p class="nomPoney"><?php echo $poney['nomPoney']; ?></p>
                                    <p><?php echo $poney['nomRace']; ?></p>
                                    <img src="../assets/images/poney/<?php echo $poney['photo']; ?>" alt="Poney <?php echo $poney['nomPoney']; ?>">
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <button type="button" id="button-left" class="nav-btn left" onclick="scrollCarousel(-1)">&#10094;</button>
                        <button type="button" id="button-right" class="nav-btn right" onclick="scrollCarousel(1)">&#10095;</button>
                    <?php
                    if($restePlace){
                        echo"<button id='ReserverValider' type='submit'>Reserver</button>";
                    }
                    ?>

                </form>

            </section>

        </main>
    </body>
    
    <script src="../assets/script/reservationCarrousel.js"></script>
</html>
