<?php
    require_once "../utils/BDD/connexionBD.php";
    require_once "../utils/annexe.php";

    estConnecte();

    if(! isset($_GET["dateDispo"]) && ! isset($_GET["debutDispo"])){
        header("Location: ../page/disponibilite.php");
        exit;
    }



    $infoDate = getDispo($bdd,$_SESSION["connecte"]["username"],$_GET["dateDispo"],(float)$_GET["debutDispo"]);
    if (!isset($infoDate)){
        header("Location: ../page/disponibilite.php");
        exit;
    }

    // echo "<pre>";
    // print_r($_GET);
    // print_r(getDispoDay($bdd,$_SESSION["connecte"]["username"],$_GET["dateDispo"]));
    // echo "</pre>";
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grand Galop</title>
    <link rel="stylesheet" href="../assets/style/style.css">
    <link rel="stylesheet" href="../assets/style/styleSousPage.css">
    <link rel="stylesheet" href="../assets/style/reservation.css">
    <link rel="stylesheet" href="../assets/style/versionTelSousPage.css">
    <link rel="stylesheet" href="../assets/style/popUp.css">
    <script src="../assets/script/popUpGestionErr.js"></script>
</head> 
    <body>
        <header>
            <h1>GRAND GALOP</h1>
            <h2>Modifier une disponibilité</h2>
            <nav class="navDispo">
            <ul>
                <li>
                    <a href="moniteur.php">Retour</a>
                </li>
            </ul>
        </nav>
        </header>
        
        <main class="container">

            <section class="gauche-section disponible">
                <form method="POST" action="../utils/moniteur/update/modifDisponibilite.php">
                    <?php
                        $timeStart = convertFloatToTime((float)$_GET["debutDispo"]);
                        $timeFinish = convertFloatToTime($infoDate["heureFinDispo"]);

                        echo "<input type='hidden' name='previousDate' value=$_GET[dateDispo]>";
                        echo "<input type='hidden' name='previousTime' value=$timeStart>";
                        
                        $date = new DateTime();
                        $resultMin = $date->format('Y-m-d');
                        $date = date_create_from_format("Y-m-d",$_GET["dateDispo"]);
                        $result = $date->format('Y-m-d');
                        if ($result < $resultMin){
                            $result = $resultMin;
                        }
                        
                        echo "<input class='styled-input' type='date' value=$result min=$resultMin name='dateDispo' id='dateDispo' required>";
                        echo "<input class='styled-input' type='time' min='01:00' max='23:00' step='1800' value=$timeStart name='heureDebut' id='heureDebut' required>";
                        echo "<input class='styled-input' type='time' min='01:00' max='23:00' step='1800' value=$timeFinish name='heureFin' id='heureFin' required>";
                    ?>
                    <input class='styled-input' type="submit" value="Modifier">
                </form>
                <form method="POST" action="../utils/moniteur/remove/removeDisponibilite.php">
                    <?php
                        $timeStart = convertFloatToTime((float)$_GET["debutDispo"]);
                        $timeFinish = convertFloatToTime($infoDate["heureFinDispo"]);

                        echo "<input type='hidden' name='previousDate' value=$_GET[dateDispo]>";
                        echo "<input type='hidden' name='previousTime' value=$timeStart>";
                        
                    ?>
                    <input class='styled-input' type="submit" value="Retirer disponibilité">
                </form>
            </section>
            
            <section class="droite-section disponible">

                <img src="../assets/images/cheval2.png" alt="cheval">

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
    
</html>
