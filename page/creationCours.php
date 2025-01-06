<?php
require_once "../utils/connexionBD.php";
require_once "../utils/functioncours.php";


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
                    <p>SELECTION DATE DE LA DATES </p>
                    <?= creerCalendrierCours($bdd, "client1") ?>
                    <!-- <figcaption>Chevaux dans la nature</figcaption> -->
                </figure>
            </section>
            
            <section class="droite-section">
                <article class="text-block">

                <form action="action.php" method="post">
                    <label>NOM</label>
                    <input name="nom" id="nom" type="text" />
                    <label>NIVEAU</label>
                    <input name="niveau" id="niveau" type="text" /></p>
                    <label>PRIX</label>
                    <input name="prix" id="prix" type="number" /></p>
                    <label>NBMAX</label>
                    <input name="nbmax" id="nbmax" type="number" /></p>
                    

                    <button type="submit">Valider</button>
                </form>

                </article>
            </section>

</html>
