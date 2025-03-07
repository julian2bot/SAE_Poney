<?php
require_once "../utils/BDD/connexionBD.php";
require_once "../utils/annexe.php";

estConnecte();

insererCotisations($bdd);

if(clientAPayerCotisation($bdd, $_SESSION["connecte"]["username"])){
    header('Location: ../');
    exit;
}

$lesCotisations = getCotisationsAnneeEnCours($bdd);

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grand Galop</title>
    <link rel="stylesheet" href="../assets/style/style.css">
    <link rel="stylesheet" href="../assets/style/reservation.css">
    <link rel="stylesheet" href="../assets/style/popUp.css">
    <link rel="stylesheet" href="../assets/style/styleSousPage.css">
</head>
    <body>
        <header>
            <h1>GRAND GALOP</h1>
            <h2>Payer la cotisation</h2>
            <nav>
            <ul>
                <li>
                    <a href="adherent.php" >Retour</a>
                </li>
            
            </ul>
        </nav>
        </header>
        
        <main class="container">

            <section class="gauche-section disponible">
                <form method="POST" action="../utils/client/cotisation/payerCotisation.php">
                    <input type="hidden" name="periode" value="<?php echo $lesCotisations[0]["periode"]?>">
                    <select name="cotisation" id="cotisation" required>
                        <?php
                        foreach($lesCotisations as $cotisation){
                            echo "<option value='$cotisation[nomCotisation]'>$cotisation[nomCotisation], prix : $cotisation[prixCotisationAnnuelle] €</option>";
                        }
                        ?>
                    </select>
                    <input type="submit" value="Payer">
                </form>
            </section>
            
            <section class="droite-section disponible">

                <img src="../assets/images/cheval2.png" alt="cheval">

            </section>

        </main>
    </body>
</html>
