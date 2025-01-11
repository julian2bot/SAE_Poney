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
                    <section>
                        <label>NOM DU COURS</label>
                        <input name="nom" id="nom" type="text" required />
                        <span class="validity"></span>
                    </section>

                    <section>
                        <label>NIVEAU DU COURS</label>
                        <script src="../assets/script/jsCreationCours.js"></script>
                        <label for="combobox">Choisissez une option :</label>
                        <select id="combobox" onchange="Combobox()" >
                            <option value=1 >NIVEAU 1</option>
                            <option value=2 >NIVEAU 2</option>
                            <option value=3 >NIVEAU 3</option>
                            <option value=4 >NIVEAU 4</option>
                            <option value=5 >NIVEAU 5</option>
                            <option value=6 >NIVEAU 6</option>
                            <option value=7 >NIVEAU 7</option>
                            <option value=8 >NIVEAU 8</option>
                            <option value=9 >NIVEAU 9</option>
                            <option value=10 >NIVEAU 10</option>
                        </select>
                        
                        <input name="niveau" id="niveau" type="text" value=1 placeholder="La valeur apparaît ici" hidden required />

                    </section>



                    <section>
                        <label>PRIX DU COURS</label>
                        <input name="prix" id="prix" type="number"  min="1" max="2500" list="defaultNumbers" required  value=0 />
                        <span class="validity"></span>

                        <datalist id="defaultNumbers">
                            <option value="400"></option>
                            <option value="200"></option>
                            <option value="350"></option>
                            <option value="10"></option>
                            <option value="99"></option>
                        </datalist>
                    </section>

                    <section>
                        <label>NOMBRE MAXIMUM DE PERSONNE</label>
                        <fieldset>
                            <div>
                                <input type="radio" id="nbmax1" name="nbmax" value=1 checked />
                                <label for="nbmax1">1</label>
                            </div>
                            <div>
                                <input type="radio" id="nbmax10" name="nbmax" value=10 />
                                <label for="choix2h">10</label>
                            </div>
                        </fieldset>
                    </section>
                    
                    <section>
                        <label>DATE DU COURS</label>
                        <p id=montrerdate>non selectionner</p>
                        <input name="datevalider" value="" id="datevalider" hidden type="date" required />
                        <span class="validity"></span>
                    </section>

                    <section>
                        <label>HEUR DU COURS</label>
                        <input class=heure type="time" id="appt" name="appt" min="06:00" max="22:00" required />
                        <span class="validity"></span>
                    </section>

                    <section>
                        <label>DUREE DU COURS</label>
                        <fieldset>
                            <div>
                                <input type="radio" id="choix1h" name="choixheure" value=1 checked />
                                <label for="choix1h">1h</label>
                            </div>
                            <div>
                                <input type="radio" id="choix2h" name="choixheure" value=2 />
                                <label for="choix2h">2h</label>
                            </div>
                        </fieldset>
                       
                    </section>




                    <button type="submit">Valider</button>


                </form>

                </article>
            </section>

</html>
