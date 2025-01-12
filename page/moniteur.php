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
        <title>Grand Galop</title>
        <link rel="stylesheet" href="../assets/style/style.css">
        <link rel="stylesheet" href="../assets/style/header.css">
        <link rel="stylesheet" href="../assets/style/styleSousPage.css">
    <link rel="stylesheet" href="../assets/style/coursCalendrier.css">
    <link rel="stylesheet" href="../assets/style/calendrier.css">
    <link rel="stylesheet" href="../assets/style/versionTel.css">

        <script src="../assets/script/popUpGestionErr.js"></script>
    </head>
    <body>
        <header>
            <h1>GRAND GALOP</h1>
            
            <?php
                if(isset($_SESSION["connecte"])){
                    echo '<div class="auth-buttons">
                            <p>'.$_SESSION["connecte"]["prenom"].'</p>
                    
                            <button onclick="location.href=\'../utils/all/login/logout.php\';" class="affichelogin">Logout</button>
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
                    
            <section id="creerCours" class="sectionPage">
                <h2 class="titreSection"> Creer un cours</h2>
            
                <section class="gauche-section gauche">
                    <!-- ? a faire calendrier -->
                    <h2 id="month-display"></h2>
                    
                    <div id="calendar-container">
                        <button class="boutonsCalendrier" id="prev-month">Mois Précédent</button>
                        <button class="boutonsCalendrier" id="next-month">Mois Suivant</button>
                        <div class="container-info-cal">
                            <div id="infoCours">
                                <p>Pas de cours</p>
                            </div>
                            <table class="calendrierLeft" id="calendrier"></table>
                        </div>
                    </div>

                </section>
                
                <section class="droite-section droite">
                    <figure class="image-block">
                            <img src="../assets/images/loginImage.jpg" alt="Cheval" class="cheval-image-droite">
                    </figure>
                </section>
            </section>

            <section id="gestionDisponibilite" class="sectionPage">
                <h2 class="titreSection">Gérer mes disponibilité</h2>
            
                <section class="gauche-section gauche">
                    <!-- ? a faire calendrier -->
                    <h2 id="month-display-disponibilite"></h2>
                    
                    <div id="calendar-container-disponibilite">
                        <button class="boutonsCalendrier" id="prev-month-disponibilite">Mois Précédent</button>
                        <button class="boutonsCalendrier" id="next-month-disponibilite">Mois Suivant</button>
                        <div class="container-info-cal">
                            <div id="info-disponibilite">
                                <p>Aucune disponibilité</p>
                            </div>
                            <table class="calendrierLeft" id="calendrier-disponibilite"></table>
                        </div>
                    </div>
                    <form action="../page/disponibilite.php" class="formBoutonCenter">
                        <input class="boutonsCalendrier" type="submit" value="Ajouter une disponibilité" />
                    </form>
                </section>
                
                <section class="droite-section droite">
                    <figure class="image-block">
                            <img src="../assets/images/SignInImage.jpg" alt="Cheval" class="cheval-image-droite">
                    </figure>
                </section>
            </section>

                                
            <section id="parametre" class="sectionPage">
                <h2 class="titreSection"> Gérer mon dossier</h2>
            
                <section class="gauche-section gauche">
                    <h2>Parametre</h2>
                    <form action="../utils/all/update/traitementParametre.php" method="post">
                        <input type="hidden" id="clientmoniteur" name="clientmoniteur" value="moniteur">
                        
                        <label for="username">Nom d'utilisateur :</label>
                        <input disabled type="text" id="username" name="username" value="<?php echo htmlspecialchars($_SESSION["connecte"]['username'] ?? ''); ?>" required><br>

                        <label for="prenom">Prénom :</label>
                        <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($_SESSION["connecte"]['prenom'] ?? ''); ?>" required><br>

                        <label for="nom">Nom :</label>
                        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($_SESSION["connecte"]['nom'] ?? ''); ?>" required><br>

                        <label for="mail">Adresse mail :</label>
                        <input type="email" id="mail" name="mail" value="<?php echo htmlspecialchars($_SESSION["connecte"]['mail'] ?? ''); ?>" required><br>

                        <button type="submit">Modifier</button>
                    </form>


                </section>
                
                <section class="droite-section droite">
                    <figure class="image-block">
                            <img src="../assets/images/cheval2.png" alt="Cheval" class="cheval-image-droite">
                    </figure>
                </section>
            </section>

        </main>
        <script src="../assets/script/coursCalendrier.js"></script>
        <script src="../assets/script/disponibiliteCalendrier.js"></script>

    </body>
    <?php
    // ouvrir le login ou signin s'il y a une erreur 
    if(isset($_GET["errChangementDonnee"])){
        // print_r($_GET);
        echo "<script type='text/javascript'>
                showPopUp(\"$_GET[errChangementDonnee]\",false);
            </script>";
    }

    if (isset($_SESSION["succes"])) {
        echo "
        <script type='text/javascript'>
                showPopUp(\"$_SESSION[succes]\");
            </script>";
        unset($_SESSION["succes"]); // Supprime la valeur après utilisation
    }

    
    if(isset($_SESSION["popUp"])){
        echo "<script type='text/javascript'>
                showPopUp(\"".$_SESSION["popUp"]["message"]."\",".($_SESSION["popUp"]["success"] ? "true" : "false").");
              </script>";
        unset($_SESSION["popUp"]);
    }
   
    ?>
</html>
