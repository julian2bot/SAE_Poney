<?php
require_once "../utils/BDD/connexionBD.php";
require_once "../utils/annexe.php";

estConnecte();
estAdmin();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration</title>
    <link rel="stylesheet" href="../assets/style/admin.css">
    <link rel="stylesheet" href="../assets/style/style.css">
    <link rel="stylesheet" href="../assets/style/header.css">
    <link rel="stylesheet" href="../assets/style/styleSousPage.css">
    <link rel="stylesheet" href="../assets/style/form.css">
    <link rel="stylesheet" href="../assets/style/coursCalendrier.css">
    <link rel="stylesheet" href="../assets/style/calendrier.css">
    <script src="../assets/script/popUpGestionErr.js"></script>
</head>
    <body style="position: relative;">
    <header class="pageAdmin">
        <nav>
            <ul>
                <li>
                    <a href="moniteur.php">
                        Retour
                    </a>
                </li>
            
            </ul>
        </nav>
    </header>


    <div class="creerPoney" id="creerPoney" style="display: none;">

        <section>
            <h2>Ajouter un Poney</h2>
            <form method="POST" action="../utils/admin/add/creerPoney.php" class="form">
                <?php
                    require "../assets/affichage/adminPoney.php";
                ?>
                <button type="submit" class="btn" name="fromSignIn">Valider</button>
            </form>
        </section>
        <img src="../assets/images/SignInImage.jpg" alt=""> 

    </div>

    <div class="creerPoney" id="creerMoniteur" style="display: none;">

        <section>
            <h2>Ajouter un moniteur</h2>
            <form method="POST" action="../utils/admin/add/creerMoniteur.php" class="form">
                <?php
                    require "../assets/affichage/adminMoniteur.php";
                ?>
                <button type="submit" class="btn" name="fromSignIn">
                    Ajouter
                </button>
            </form>
        </section>
        <img src="../assets/images/SignInImage.jpg" alt=""> 

    </div>

    <div class="creerPoney" id="modifierPoney" style="display: none;">

        <section>
            <h2>ModifIer un Poney</h2>
            <form method="POST" action="../utils/modifPoney.php" class="form">
                <input type="hidden" name="identifiant" class="identifiant form-control-material" required>
                <?php
                    require "../assets/affichage/adminPoney.php";
                ?>
                <button type="submit" class="btn" name="fromSignIn">Valider</button>
            </form>
        </section>
        <img src="../assets/images/SignInImage.jpg" alt=""> 

    </div>

    <div class="creerPoney" id="modifierMoniteur" style="display: none;">

        <section>
            <h2>Modifier un moniteur</h2>
            <form method="POST" action="../utils/modifMoniteur.php" class="form">
                <input type="hidden" name="identifiant" class="identifiant form-control-material" required>
                <input type="hidden" name="ancienMail" class="ancienMail form-control-material" required>
                <?php
                    require "../assets/affichage/adminMoniteur.php";
                ?>
                <button type="submit" class="btn" name="fromSignIn">
                    Ajouter
                </button>
            </form>
        </section>
        <img src="../assets/images/SignInImage.jpg" alt=""> 

    </div>

    <div class="calendrierPoney" id="calendrierPoney"
         style="display: none;">

        <h2>Calendrier du Poney</h2>
        <h3 id="month-display"></h3>
                    
        <div id="calendar-container">
            <button class="boutonsCalendrier" id="prev-month">Mois Précédent</button>
            <button class="boutonsCalendrier" id="next-month">Mois Suivant</button>
            <div class="container-info-cal">
                <div id="infoCours">
                    <p >
                        Pas de cours
                    </p>
                </div>
                <table id="calendrier"></table>
            </div>
        </div>

    </div>

    <div id="flou" class="admin-container">
        <!-- Section des cas d'utilisation -->
        <header>
            <h1>Administration</h1>
            <p>Gestion des tâches administratives</p>
        </header>

        <main>
        
        <!-- Section des listes -->
            <section class="lists-section">
                
                <h2>Gestion des Poneys & Clients</h2>
                
                
                <!-- liste des PONEYs -->
                <div class="list" style="overflow:scroll; max-height:500px;">
                    <h3 id="Poney">Liste des Poneys</h3>
                    
                    <ul id="pony-list">
                        <?php
                        
                        foreach (getPoney($bdd) as $poney) {
                            echo '<li>'.$poney["nomPoney"].'';
                            echo "<div class = 'boutons'>";
                            echo "<button onclick=' afficheCalendrierPoney(".$poney["idPoney"].")' class='remove-btn'>Calendrier</button>";
                            echo "<button onclick='remplirPoneyModif(\"".$poney["idPoney"]."\",\"".$poney["nomPoney"]."\",\"".$poney["poidsMax"]."\",\"".$poney["photo"]."\",\"".$poney["nomRace"]."\")' class='remove-btn'>Modifier</button>";
                            echo '<a href="../utils/admin/remove/removePoney.php?idPoney='.$poney["idPoney"].'" class="remove-btn">Retirer</a>';
                            echo "</div>";
                            echo "</li>";
                        }
                        
                        ?>
                    </ul>
                </div>
                <!-- <button class="add-btn" onclick="afficheCreerPoney()" id="page poney">Ajouter un Poney</button> -->
                <button class="add-btn" id="creation_poney">Ajouter un Poney</button>
                    
                <!-- liste des moniteurs -->
                <div class="list" style="overflow:scroll; max-height:500px;">
                    <h3 id="Moniteurs">Liste des Moniteurs</h3>
                    <ul id="client-list">
                        <?php
                        
                        foreach (getMoniteur($bdd) as $moniteur) {
                            $info = getInfo($bdd,$moniteur["usernameMoniteur"]);
                            echo '<li>'.$moniteur["usernameMoniteur"].'';
                            echo "<div class='boutons'>";
                            // echo "<button onclick='remplirMoniteurModif(\"".$info["prenomPersonne"]."\",\"".$info["mail"]."\",\"".$info["username"]."\",\"".$info["prenomPersonne"]."\",\"".$info["nomPersonne"]."\",\"".$info["mail"]."\",\"".($info["isAdmin"] == 1 ? "oui" : "non")."\",\"".$info["salaire"]."\")' class='remove-btn'>Modifier</button>";
                            
                            echo "<button onclick='remplirMoniteurModif(\"".($info["username"] ?? "")."\",\"".($info["mail"] ?? "")."\",\"".($info["username"] ?? "")."\",\"".($info["prenomPersonne"] ?? "")."\",\"".($info["nomPersonne"] ?? "")."\",\"".($info["mail"] ?? "")."\",\"".(($info["isAdmin"] ?? 0) == 1 ? "oui" : "non")."\",\"".($info["salaire"] ?? "")."\")' class='remove-btn'>Modifier</button>";

                            echo '<a href="../utils/admin/remove/removeMoniteur.php?id='.$moniteur["usernameMoniteur"].'" class="remove-btn">Retirer</a>';
                            echo "</div>";
                            echo "</li>";
                        }

                        ?>                
                    </ul>
                </div>
                <button class="add-btn" id="creation_moniteur">Ajouter un moniteur</button>

                <!-- liste des clients -->
                <div class="list" style="overflow:scroll; max-height:500px;">
                        <h3 id="Clients">Liste des Clients</h3>
                    <ul id="client-list">
                        <?php
                        
                        foreach (getClient($bdd) as $client) {
                            echo '<li>'. $client["usernameClient"].' <a href="../utils/admin/remove/removeClient.php?id='.$client["usernameClient"].'" class="remove-btn">Retirer</a></li>';
                        }

                        ?>                
                    </ul>
                </div>

            </section>
        </main>
        <script src="../assets/script/afficherAdmin.js"></script>
    </div>
    </body>

    <?php
    // ouvrir le login ou signin s'il y a une erreur 
    if(isset($_GET["erreurCreerPoney"])){
        // print_r($_SESSION["erreur"]);
        echo "<script type='text/javascript'>
                    remplirPoney('".$_SESSION["erreur"]["nomPoney"]."','".$_SESSION["erreur"]["poidMax"]."','".$_SESSION["erreur"]["photo"]."','".$_SESSION["erreur"]["race"]."');
              </script>";
    }
    if(isset($_GET["erreurCreerMoniteur"])){
        // print_r($_GET);
        echo "<script type='text/javascript'>
                    remplirMoniteur('".$_SESSION["erreur"]["usernameMoniteur"]."','".$_SESSION["erreur"]["prenomMoniteur"]."','".$_SESSION["erreur"]["nomMoniteur"]."','".$_SESSION["erreur"]["Mail"]."','".$_SESSION["erreur"]["estAdmin"]."','".$_SESSION["erreur"]["salaire"]."');
              </script>";
    }
    if(isset($_GET["erreurModifPoney"])){
        // print_r($_SESSION["erreur"]);
        echo "<script type='text/javascript'>
                    remplirPoneyModif('".$_SESSION["erreur"]["identifiant"]."','".$_SESSION["erreur"]["nomPoney"]."','".$_SESSION["erreur"]["poidMax"]."','".$_SESSION["erreur"]["photo"]."','".$_SESSION["erreur"]["race"]."');
              </script>";
    }
    if(isset($_GET["erreurModifMoniteur"])){
        // print_r($_GET);
        echo "<script type='text/javascript'>
                    remplirMoniteurModif('".$_SESSION["erreur"]["identifiant"]."','".$_SESSION["erreur"]["ancienMail"]."','".$_SESSION["erreur"]["usernameMoniteur"]."','".$_SESSION["erreur"]["prenomMoniteur"]."','".$_SESSION["erreur"]["nomMoniteur"]."','".$_SESSION["erreur"]["Mail"]."','".$_SESSION["erreur"]["estAdmin"]."','".$_SESSION["erreur"]["salaire"]."');
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

