<?php
require_once "../utils/BDD/connexionBD.php";
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

                    <button id="ReserverValider" type="submit">Reserver</button>

                </form>

            </section>

        </main>
    </body>
    
    <script src="../assets/script/reservationCarrousel.js"></script>
</html>
