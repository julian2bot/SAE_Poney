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
    <link rel="stylesheet" href="../assets/style/header.css">
    <link rel="stylesheet" href="../assets/style/styleSousPage.css">
    <link rel="stylesheet" href="../assets/style/calendrier.css">
    <script src="../assets/script/popUpGestionErr.js"></script>
    
</head>
    
    <body>
        <header>
            <h1>GRAND GALOP</h1>
            
            <?php
                if(isset($_SESSION["connecte"])){
                    echo '<div class="auth-buttons">
                            <p>'.$_SESSION["connecte"]["prenom"].'</p>
                    
                            <button onclick="location.href=\'../utils/logout.php\';" class="affichelogin">Logout</button>
                        </div>';
                    include "../assets/affichage/header.php";
                }
                else{
                    echo '<div class="auth-buttons">
                        <button class="affichelogin">Login</button>
                        <button class="afficheSignIn">Sign In</button>
                    </div>';
                }
            ?>
        </header>
        
        <main class="container">

            <section id="planning" class="sectionPage">
                <h2 class="titreSection"> Planning</h2>
                <section class="gauche-section gauche">
                <?php
                    creerCalendrier($bdd, $_SESSION["connecte"]["username"]);
                ?>

                </section>
                
                <section class="droite-section droite">
                    <figure class="image-block">
                        <img src="../assets/images/cheval2.png" alt="Cheval" class="cheval-image-droite">
                    </figure>
                </section>
            </section>
                    
            <section id="reserverCours" class="sectionPage">
                <h2 class="titreSection"> Réserver un cours</h2>
            
                <section class="gauche-section gauche">
                    <!-- ? a faire calendrier -->
                    <figure class="image-block">
                        <img src="../assets/images/cal.png" alt="cal" class="planning">
                    </figure>
                </section>
                
                <section class="droite-section droite">
                    <figure class="image-block">
                            <img src="../assets/images/cheval2.png" alt="Cheval" class="cheval-image-droite">
                    </figure>
                </section>
            </section>

                                
            <section id="parametre" class="sectionPage">
                <h2 class="titreSection"> Gérer mon dossier</h2>
            
                <section class="gauche-section gauche">
                    <figure class="image-block">
                        <img src="../assets/images/cal.png" alt="cal" class="planning">
                    </figure>
                </section>
                
                <section class="droite-section droite">
                    <figure class="image-block">
                            <img src="../assets/images/cheval2.png" alt="Cheval" class="cheval-image-droite">
                    </figure>
                </section>
            </section>

        </main>


        <!-- POP UP GESTION ERREUR -->
        <div id="errReservCours" class="erreur">
            <?php 
            if(isset($_GET["errReservCours"])){
                // print_r($_GET);
                echo $_GET["errReservCours"];
            }
             ?>
        </div>


    </body>
    <?php
    // ouvrir le login ou signin s'il y a une erreur 
    if(isset($_GET["errReservCours"])){
        // print_r($_GET);
        echo '<script type="text/javascript">
                popUpErreur();
            </script>';
    }
    ?>

</html>
