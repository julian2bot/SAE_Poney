<?php
require_once "../utils/connexionBD.php";
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grand Galop</title>
    <link rel="stylesheet" href="../assets/style/style.css">
    <link rel="stylesheet" href="../assets/style/creationCoursCss.css">
</head>
    <body>
        <header>
            <h1>GRAND GALOP</h1>

            <div class="auth-buttons">
                <button class="affichelogin">Login</button>
                <button class="afficheSignIn">Sign In</button>
            </div>
        </header>
        
        <main class="container">

            <section class="gauche-section">
                <figure class="image-block">
                </figure>
                <p>Selectionner la date</p>

                
                <?php include '../utils/functioncours.php'; ?>
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
                    <?php generercase($firstDayOfWeek,$daysInMonth,$month,$year) ?>
                    </tr>
                </table>
                


            </section>
            
            <section class="droite-section">
                <article class="text-block">

                <form action="action.php" method="post">
                    <label>NOM</label>
                    <input name="nom" id="nom" type="text" required />
                    <label>NIVEAU</label>
                    <input name="niveau" id="niveau" type="text" required />
                    <label>PRIX</label>
                    <input name="prix" id="prix" type="number" required />
                    <label>NBMAX</label>
                    <input name="nbmax" id="nbmax" type="number" required />

                    <label>DATE</label>
                    <p id=montrerdate>non selectionner</p>
                    <input name="datevalider" value="" id="datevalider" hidden type="date" required />

                    <label>HEUR</label>

                    <input type="time" id="appt" name="appt" min="09:00" max="18:00" required />


                    <button type="submit">Valider</button>


                </form>

                </article>
            </section>

</html>
