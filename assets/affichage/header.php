<?php

if($_SESSION["connecte"]["role"] ==="client"){
    
    echo '<header>
            <nav>
            <ul>    
                <li>
                <a href="#planning">Planning</a>
                </li>
                
                <li>
                <a href="#reserverCours">Reserver cours</a>
                </li>
                
                <li>
                <a href="#parametre">Paramètres</a>
                </li>
            </nav>
        </header>';
}
elseif($_SESSION["connecte"]["role"] ==="moniteur"){
    echo 
        '<header>
            <nav>
            <ul>    
                <li>
                    <a href="#planning">Planning</a>
                </li>
                
                <li>
                    <a href="#creerCours">Créer un cours</a>
                </li>
                
                <li>
                    <a href="#gestionDisponibilite">Disponibilités</a>
                </li>
                                
                <li>
                    <a href="gestionReserv.php">Réservations</a>
                </li>

                <li>
                    <a href="#parametre">Paramètres</a>
                </li>
            </nav>
        </header>';
}
elseif($_SESSION["connecte"]["role"] === "admin"){
    echo 
        '<header>
            <nav>
            <ul>    
                <li>
                    <a href="#planning">Planning</a>
                </li>
                
                <li>
                    <a href="#creerCours">Créer un cours</a>
                </li>

                <li>
                    <a href="#gestionDisponibilite">Disponibilités</a>
                </li>
                
                <li>
                    <a href="#parametre">Paramètres</a>
                </li>
                
                <li>
                    <a href="gestionReserv.php">Réservations</a>
                </li>

                <li>
                    <a href="administration.php">Administration</a>
                </li>
            </nav>
        </header>';
}
    
?>

