<?php
require_once "../utils/BDD/connexionBD.php";
require_once "../utils/annexe.php";
require_once "../utils/constante.php";

estConnecte();

if( !clientAPayerCotisation($bdd, $_SESSION["connecte"]["username"])){
    createPopUp("Vous devez payer la cotisation annuelle avant de pouvoir vous inscrire au cours",false);
    header('Location: ../');
    exit;
}


?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grand Galop</title>
    <link rel="stylesheet" href="../assets/style/style.css">
    <link rel="stylesheet" href="../assets/style/header.css">
    <link rel="stylesheet" href="../assets/style/reservation.css">
    
    <link rel="stylesheet" href="../assets/style/coursCalendrier.css">
    <link rel="stylesheet" href="../assets/style/calendrier.css">
    <link rel="stylesheet" href="../assets/style/styleSousPage.css">
    <link rel="stylesheet" href="../assets/style/popUp.css">
    <script src="../assets/script/popUpGestionErr.js"></script>
</head>
    <body>
        <header>
            <h1>GRAND GALOP</h1>
            <h2>Demander un cours</h2>
            <nav>
            <ul>
                <li>
                    <a href="adherent.php" >
                        Retour
                    </a>
                </li>
            
            </ul>
        </nav>
        </header>
        
        <main class="container">

            <section class="gauche-section">
            <h2 id="month-display"></h2>

                <div id="calendrierSelect">
                    <button class="boutonsCalendrier" id="prev-month">Mois Précédent</button>
                    <button class="boutonsCalendrier" id="next-month">Mois Suivant</button>
                    
                    <table id="calendrier"></table>

                </div>
            </section>
            
            <section class="droite-section demandeCoursDroite">

                <form method="POST" action="../utils/client/cours/demandeDeCours.php" class="formReserv" id="formDemandeCours">
                    <div class="container-carrousel-poney" id="carrousel">
                        <?php $cpt=0;?>
                        <?php foreach (getPoney($bdd) as $poney): ?>
                            <div class="poney-item">
                                <input type="radio" <?php if($cpt == 0) echo 'required'?>  id="poney<?php echo $poney['idPoney']; ?>" name="poneySelectionne" value="<?php echo $poney['idPoney']; ?>">
                                <label for="poney<?php echo $poney['idPoney']; ?>">
                                    <p class="nomPoney"><?php echo $poney['nomPoney']; ?></p>
                                    <p><?php echo $poney['nomRace']; ?></p>
                                    <img src="../assets/images/poney/<?php echo $poney['photo']; ?>" alt="Poney <?php echo $poney['nomPoney']; ?>">
                                </label>
                            </div>
                            <?php $cpt++?>
                        <?php endforeach; ?>
                    </div>
                    
                    <button type="button" id="button-left" class="nav-btn left" onclick="scrollCarousel(-1)">&#10094;</button>
                    <button type="button" id="button-right" class="nav-btn right" onclick="scrollCarousel(1)">&#10095;</button>
                    
                    <input type="hidden" name="usernameClient" required id="usernameClient" value="<?php echo $_SESSION["connecte"]["username"]?>"/>
                    <input type="hidden" name="dateDemandeCours" required id="dateDemandeCours" value=""/>
                    <input type="hidden" name="niveau" required id="niveauAdherent" value="<?php echo $_SESSION["connecte"]["info"]["niveau"]?>"/>
                    
                    <label for="heureCours">Heure début du cours</label>
                    <input class="styled-input" type="time" required name="heureCours" id="heureCoursReserv"  min='01:00' max='23:00' step='1800' >
                    
                    <label for="heure">Nombre d'heures pour le cours:</label>
                    <select class="styled-input" name="heure" class="heure" required>
                        
                        <option value="1">1h</option>
                        <option value="2">2h</option>
                    </select>
                    
                    <textarea class="styled-textarea" name="activiteDuCours" placeholder="J'aimerais faire un cours pour réviser ....." maxlength="200"></textarea>

                    <button id="ReserverValider" type="submit">Reserver</button>

                </form>

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
    
    <script src="../assets/script/reservationCarrousel.js"></script>
    <script src="../assets/script/demandeCours.js"></script>

    
</html>


