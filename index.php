<?php
require_once "utils/BDD/connexionBD.php";

if(isset($_SESSION["connecte"])){
    switch ($_SESSION["connecte"]["role"]) {
        case 'client':
            header("Location: page/adherent.php");
            exit;
            break;
        case "moniteur":
        case "admin":
            header("Location: page/moniteur.php");
            exit;
            break;
        
        default:
            header("Location: page/404.php");
            exit;
            break;
    }
}


?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grand Galop</title>
    <link rel="stylesheet" href="assets/style/style.css">
    <link rel="stylesheet" href="assets/style/form.css">
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
                    <img src="assets/images/cheval.png" alt="Cheval" class="cheval-image">
                    <!-- <figcaption>Chevaux dans la nature</figcaption> -->
                </figure>
            </section>
            
            <section class="droite-section">
                <article class="text-block">
                        <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis quam dignissim, consequat magna et, fringilla diam. Fusce egestas id elit ac laoreet. In ut viverra velit, eget iaculis enim. Ut vel lectus vel nunc luctus blandit at sit amet eros. Cras hendrerit laoreet pharetra. Donec pellentesque dui sed ante vehicula mattis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus venenatis ante nisl, volutpat facilisis lectus tristique vestibulum. Morbi non velit purus. Nam euismod enim eget purus vehicula, non tristique sapien pulvinar. Sed mollis odio lobortis lectus hendrerit, malesuada facilisis nunc consectetur. Etiam ut risus et mi tincidunt molestie. Vestibulum scelerisque risus sem. Aenean placerat mi et commodo pellentesque.
                        </p>
                </article>
            </section>

            <img src="assets/images/logo-ffe.png" alt="Cheval" class="cheval">
            
            <div class="login" id="login">
                <section>
                    <h2>Login</h2>
                    <p>Entrer vos compte pour vous connecter</p>
                    <form method="POST" action ="utils/all/login/login.php" class="form">

                        <label for="Name">UserName</label>
                        <input type="text" name="Name" id="Name" placeholder="UserName" autocomplete="off" class="form-control-material">

                        <!-- passWord -->
                        <label for="PassWordLogin">Password</label>
                        <input type="password" name="PassWordLogin" id="PassWordLogin" placeholder="PassWord" autocomplete="off" class="form-control-material">
                        <!-- <img src="assets/images/eye-off.png" id="eye" onclick="" alt=""> -->
                        <?php
                        if(isset($_GET["erreurLogin"])){

                            echo '<font color="red">'.$_GET["erreurLogin"]."</font>";
                        }
                        ?>
                        <button type="submit" class="btn" name="fromLogin">
                            Envoyer
                        </button>
                        <a href="#" class="afficheSignIn">Sign In</a>
                    </form>
                </section>

                <img src="assets/images/loginImage.jpg" alt="">
            </div>

            <div class="signIn" id="signIn">
                <img src="assets/images/SignInImage.jpg" alt=""> 
                <section>
                    <h2>SignIn</h2>
                    <p>Entrer vos compte pour vous connecter</p>
                    <form method="POST" action="utils/all/login/signIn.php" class="form">

                        <label for="NameSignIn">UserName</label>
                        <input type="text" name="NameSignIn" id="NameSignIn" placeholder="UserName" autocomplete="off" class="form-control-material">

                        <label for="nomSignIn">nom</label>
                        <input type="text" name="nomSignIn" id="nomSignIn" placeholder="nom" autocomplete="off" class="form-control-material">
                        
                        <label for="prenomSignIn">prenom</label>
                        <input type="text" name="prenomSignIn" id="prenomSignIn" placeholder="prenom" autocomplete="off" class="form-control-material">
                        
                        <label for="Mail">Mail</label>
                        <input type="email" name="Mail" id="Mail" placeholder="Email" autocomplete="off" class="form-control-material">
                        
                        <label for="poids">Votre Poids</label>
                        <input type="number" name="poids" id="poids" placeholder="poids" autocomplete="off" class="form-control-material">

                        <!-- passWord -->
                        <label for="Password">Password</label>
                        <input type="password" name="Password" id="Password" placeholder="PassWord" autocomplete="off" class="form-control-material">
                        
                        <label for="RePassword">Re-Password</label>
                        <input type="password" name="RePassword" id="RePassword" placeholder="Re-Password" autocomplete="off" class="form-control-material">
                        <?php
                        if(isset($_GET["erreurSignIn"])){
                            echo '<font color="red">'.$_GET["erreurSignIn"]."</font>";
                        }
                        ?>

                        <button type="submit" class="btn" name="fromSignIn">
                            Envoyer
                        </button>
                        <a href="#" class="affichelogin">Login</a>
                    </form>
                </section>

                <!-- <img src="assets/images/loginImage.jpg" alt="">  -->
            </div>
        </main>
        <script src="assets/script/afficher.js"></script>
        <script src="assets/script/from.js"></script>
    </body>

    <?php
    // ouvrir le login ou signin s'il y a une erreur 
    if(isset($_GET["erreurLogin"])){
        // print_r($_GET);
        echo '<script type="text/javascript">
                afficheLogin();
                </script>';
    }
    elseif (isset($_GET["erreurSignIn"])) {
        echo '<script type="text/javascript">
            afficheSignIn();
        </script>';
    }
    ?>
</html>
