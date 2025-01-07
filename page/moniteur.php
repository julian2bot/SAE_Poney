<?php
require_once "../utils/connexionBD.php";

require_once "../utils/annexe.php";
estConnecte();

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
        <link rel="stylesheet" href="../assets/style/calendrier.css">
        <script src="../assets/script/popUpGestionErr.js"></script>
    </head>
    <body>
        <header>
            <h1>GRAND GALOP</h1>
            
            <?php
                //
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
                    
            <section id="creerCours" class="sectionPage">
                <h2 class="titreSection"> Creer un cours</h2>
            
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
                    <h2>Parametre page</h2>
                    <form action="../utils/traitementParametreMoniteur.php" method="post">
                        <input type="hidden" name="clientmoniteur" value="client">
                        
                        
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



        <!-- POP UP GESTION ERREUR -->
        <div id="errReservCours" class="erreur">
            <?php 
            if(isset($_GET["errChangementDonnee"])){
                // print_r($_GET);
                echo $_GET["errChangementDonnee"];
            }
             ?>
        </div>


        <div id="succesEditMoniteur" class="succes" >
            <?php 
            if(isset($_SESSION["succes"])){
                // print_r($_GET);
                echo $_SESSION["succes"];
            }
             ?>
        </div>


    </body>
    <?php
    // ouvrir le login ou signin s'il y a une erreur 
    if(isset($_GET["errChangementDonnee"])){
        // print_r($_GET);
        echo '<script type="text/javascript">
                popUpErreur();
            </script>';
    }



    if (isset($_SESSION["succes"])) {
        echo '
        <script type="text/javascript">
                popUpSucces();
            </script>';
        unset($_SESSION["succes"]); // Supprime la valeur après utilisation
    }
    ?>
</html>
