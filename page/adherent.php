<?php
require_once "../utils/BDD/connexionBD.php";
require_once "../utils/annexe.php";
estConnecte();
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";
$aPayerCotisation = clientAPayerCotisation($bdd, $_SESSION["connecte"]["username"]);
$solde = getSoldeClient($bdd,$_SESSION["connecte"]["username"]);
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
    <link rel="stylesheet" href="../assets/style/coursCalendrier.css">
    <link rel="stylesheet" href="../assets/style/calendrier.css">
    <link rel="stylesheet" href="../assets/style/versionTel.css">
    <link rel="stylesheet" href="../assets/style/popUp.css">
    <script src="../assets/script/popUpGestionErr.js"></script>
</head>
    
    <body>
        <header>
            <h1>GRAND GALOP</h1>
            
            <?php
                if(isset($_SESSION["connecte"])){
                    echo '<div class="auth-buttons">
                            <p>'.$_SESSION["connecte"]["prenom"].'</p>
                            <p id="solde">Solde : '.$solde.' €</p>
                    
                            <button onclick="location.href=\'../utils/all/login/logout.php\';" class="affichelogin">Logout</button>
                        </div>';
                    if(! $aPayerCotisation){
                        echo "<div id='cotisationNonPayer'>";
                        echo "<div>";
                        echo "<img src='../assets/images/warning.png' alt='warning'>";
                        echo "<p>Vous n'avez pas payé la cotisation pour cette année, veuillez la payer afin de pouvoir réserver des cours.</p>";
                        echo "<a href='./payerCotisation.php'>Payer</a>";
                        echo "</div>";
                        echo "</div>";
                    }
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
                    <h2 id="month-display"></h2>
                    
                    <div id="calendar-container">
                        <button class="boutonsCalendrier" id="prev-month">Mois Précédent</button>
                        <button class="boutonsCalendrier" id="next-month">Mois Suivant</button>
                        <div class="container-info-cal">
                            <div id="infoCours">
                                <p >
                                    Pas de cours
                                </p>
                            </div>
                            <table class="calendrierLeft" id="calendrier"></table>
                        </div>
                    </div>
                    <a class="formBoutonCenter" href="demandeCours.php">Demande de cours</a>
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
                        <input type="hidden" id="clientmoniteur" name="clientmoniteur" value="client">

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
                    <button onclick='add100ToSolde("<?php echo htmlspecialchars($_SESSION["connecte"]["username"]) ?>")'>Add 100€</button>

                </section>
                
                <section class="droite-section droite">
                    <figure class="image-block">
                            <img src="../assets/images/loginImage.jpg" alt="Cheval" class="cheval-image-droite">
                    </figure>
                </section>
            </section>

        <script src="../assets/script/coursCalendrier.js"></script>
        <script src="../assets/script/soldeClient.js"></script>

        </main>

    </body>
    <?php
    // ouvrir le login ou signin s'il y a une erreur 
    if(isset($_GET["errReservCours"])){
        // print_r($_GET);
        echo "<script type='text/javascript'>
                popUpErreur(\"$_GET[errReservCours]\", false);
            </script>";
    }

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
