<?php
require_once "../utils/connexionBD.php";
require_once "../utils/annexe.php";

estConnecte();

// if( !isset($_GET["idcours"]) AND !isset($_GET["dateCours"]) AND !isset($_GET["heureCours"])){
//     header('Location: ../');
//     exit;
// }


// $infoDuCours = getInfoCours($bdd, $_GET["idcours"], $_GET["dateCours"], $_GET["heureCours"]);



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
    
    <link rel="stylesheet" href="../assets/style/coursCalendrier.css">
    <link rel="stylesheet" href="../assets/style/calendrier.css">
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

            <section class="gauche-section" style="width:auto;">
            <h2 id="month-display"></h2>

                <div id="calendrierSelect">
                    <button class="boutonsCalendrier" id="prev-month">Mois Précédent</button>
                    <button class="boutonsCalendrier" id="next-month">Mois Suivant</button>
                    
                    <table id="calendrier"></table>

                </div>
            </section>
            
            <section class="droite-section">

                <form action="../utils/demandeDeCours.php" method="post" class="formReserv">


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
                        
                        
                        
                        <input type="hidden" name="dateDemandeCours" required id="dateDemandeCours" value=""/>
                        
                        <label for="heureCours">Heure debut du cours</label>
                        <input type="time" required name="heureCours" id="heureCoursReserv"  min='01:00' max='23:00' step='1800' >
                        
                        <label for="heure">Nombre d'heure pour le cours:</label>
                        <select name="heure" class="heure" required>

                            <option value="1">1h</option>
                            <option value="2">2h</option>
                        </select>


                    <button id="ReserverValider" type="submit">Reserver</button>

                </form>

            </section>

        </main>
    </body>
    
    <script src="../assets/script/reservationCarrousel.js"></script>
    <script src="../assets/script/demandeCours.js"></script>
</html>
