<?php
// session_start();
// echo __DIR__."./../../utils/connexion.php";
require_once "../utils/connexionBD.php";
// require_once __DIR__ . "/../../utils/connexion.php";

require_once "../utils/annexe.php";
if(!isset($_SESSION["connecte"])){
    header("Location: ../");
}


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
            <h2 id="planning" class="titreSection"> Planning</h2>
            <section class="image-section">
                <figure class="image-block">
                    <img src="assets/images/cheval.png" alt="Cheval" class="cheval-image">
                    <!-- <figcaption>Chevaux dans la nature</figcaption> -->
                </figure>
            </section>
            
            <section class="text-section">
                <article class="text-block">
                        <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis quam dignissim, consequat magna et, fringilla diam. Fusce egestas id elit ac laoreet. In ut viverra velit, eget iaculis enim. Ut vel lectus vel nunc luctus blandit at sit amet eros. Cras hendrerit laoreet pharetra. Donec pellentesque dui sed ante vehicula mattis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus venenatis ante nisl, volutpat facilisis lectus tristique vestibulum. Morbi non velit purus. Nam euismod enim eget purus vehicula, non tristique sapien pulvinar. Sed mollis odio lobortis lectus hendrerit, malesuada facilisis nunc consectetur. Etiam ut risus et mi tincidunt molestie. Vestibulum scelerisque risus sem. Aenean placerat mi et commodo pellentesque.
                        </p>
                </article>
            </section>

        </main>
    </body>

</html>
