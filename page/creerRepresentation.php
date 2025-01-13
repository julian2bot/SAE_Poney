<?php
    require_once "../utils/BDD/connexionBD.php";
    require_once "../utils/annexe.php";
    estConnecte();


    
    // Gestion des dates pour le calendrier avec une approche différente
    $month = isset($_GET['month']) ? intval($_GET['month']) : date('n');
    $year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

    // Calculer les mois précédent et suivant en utilisant mktime
    $prevMonthTime = mktime(0, 0, 0, $month - 1, 1, $year);
    $nextMonthTime = mktime(0, 0, 0, $month + 1, 1, $year);

    $prevMonth = date('n', $prevMonthTime);
    $prevYear = date('Y', $prevMonthTime);
    $nextMonth = date('n', $nextMonthTime);
    $nextYear = date('Y', $nextMonthTime);

    // Nombre de jours dans le mois courant
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    // Jour de la semaine du premier jour du mois
    $firstDayOfWeek = date('N', strtotime("$year-$month-01")) - 1;

    // Nom des jours et des mois
    $daysOfWeek = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
    $months = [
        1 => 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
        'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
        
    ];

    $lesCours = getLesCoursSansPerso($bdd);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grand Galop</title>
    <link rel="stylesheet" href="../assets/style/style.css">
    <link rel="stylesheet" href="../assets/style/creationCoursCss.css">
    <link rel="stylesheet" href="../assets/style/popUp.css">
    <script src="../assets/script/jsCreationCours.js"></script>
    <script src="../assets/script/popUpGestionErr.js"></script>
</head>
    <body>
        <header>
            <h1>GRAND GALOP</h1>
            <h2>Créer une représentation</h2>
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
            <section class="gauche-section sectionFormCours">
                <a href="creerCours.php">Créer un cours</a>
                <form action="../utils/moniteur/cours/creerRepresentation.php" method="POST">

                    <div>
                        <label for="cours">Cours</label>
                        <select class="styled-input" name="cours" id="cours" id="cours" required>
                            <?php
                                foreach ($lesCours as $cours) {
                                    echo "<option value='$cours[idCours]'>$cours[nomCours]</option>";
                                }
                            ?>
                        </select>
                    </div>
                    
                    <div>
                        <label for="datevalider">Date du cours</label>
                        <p id=montrerdate>non selectionné</p>
                        <input class="styled-input" name="datevalider" id="datevalider" hidden type="date" required />
                    </div>

                    <div>
                        <label for="temp">Heure du cours</label>
                        <input class="styled-input heure" type="time" id="temp" name="temp" min='01:00' max='22:00' step='1800' required />
                    </div>

                    <div>
                        <label for="description">Description</label>
                        <input class="styled-input" type="text" id="description" name="description" min=0 max=30 placeholder="Ajouter une description" list="liste description automatique" required />

                        <!-- <datalist id="liste description automatique">
                            <option value="Apprentissage des bases."></option>
                            <option value="Promenade à poney/cheval."></option>
                            <option value="Jeux équestres simples:"></option>
                            <option value="Découverte des soins:"></option>
                            <option value="Cours collectifs:"></option>
                            <option value="Cours particuliers:"></option>
                            <option value="Stages équestres:"></option>
                            <option value="Préparation aux galops:"></option>
                            <option value="Balades et randonnées:"></option>
                            <option value="Bivouacs ou randonnées sur plusieurs jours:"></option>
                            <option value="Dressage:"></option>
                            <option value="Saut d'obstacles (CSO):"></option>
                            <option value="Cross:"></option>
                            <option value="Voltige:"></option>
                            <option value="TREC (Techniques de Randonnée Équestre de Compétition):"></option>
                            
                            <option value="Longues rênes:"></option>
                            <option value="Longe:"></option>
                            <option value="Éducation éthologique:"></option>
                            <option value="Liberté:"></option>
                            
                            <option value="Ateliers de pansage:"></option>
                            <option value="Toilettage et tressage:"></option>
                            <option value="Alimentation:"></option>
                            <option value="Découverte de la maréchalerie:"></option>
                            <option value="Balnéothérapie:"></option>
                            <option value="Massage équin et stretching:"></option>

                            <option value="Préparation aux concours:"></option>
                            <option value="Perfectionnement technique:"></option>
                            <option value="Randonnées sportives:"></option>
                            <option value="Approche du travail de jeunes chevaux:"></option>
                        </datalist> -->
                    </div>

                    <button type="submit">Valider</button>
                </form>
            </section>
            
            <section class="droite-section">
                <h1>Calendrier - <?php echo $months[$month] . ' ' . $year; ?></h1>

                <div class="navigation">
                    <a href="?month=<?php echo $prevMonth; ?>&year=<?php echo $prevYear; ?>">&laquo; Mois précédent</a>
                    <a href="?month=<?php echo $nextMonth; ?>&year=<?php echo $nextYear; ?>">Mois suivant &raquo;</a>
                </div>

                <table>
                    <tr>
                        <?php foreach ($daysOfWeek as $day): ?>
                            <th><?php echo $day; ?></th>
                        <?php endforeach; ?>
                    </tr>

                    <tr>
                    <?php $valeurbase = generercase($firstDayOfWeek,$daysInMonth,$month,$year) ?>
                    </tr>
                </table>
            </section>
        </main>
    </body>
    <?php
        if(isset($_GET["day"])){
            echo "<script type='text/javascript'>
                changerTexte(\"".$_GET["day"]."\",\"".$_GET["month"]."\",\"".$_GET["year"]."\");
                </script>";
        }
        else if(isset($valeurbase["jour"])){
            echo "<script type='text/javascript'>
                changerTexte(\"".$valeurbase["jour"]."\",\"".$valeurbase["mois"]."\",\"".$valeurbase["annee"]."\");
                </script>";
        }

        if(isset($_SESSION["popUp"])){
            echo "<script type='text/javascript'>
                    showPopUp(\"".$_SESSION["popUp"]["message"]."\",".($_SESSION["popUp"]["success"] ? "true" : "false").");
                  </script>";
            unset($_SESSION["popUp"]);
        }
    ?>
</html>
