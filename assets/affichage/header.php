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
                <a href="#parametre">Parametre</a>
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
                    <a href="#creerCours">Creer cours</a>
                </li>
                
                <li>
                    <a href="#gestionDisponibilite">Disponibilité</a>
                </li>
                                
                <li>
                    <a href="gestionReserv.php">Reservations</a>
                </li>

                <li>
                    <a href="#parametre">Parametre</a>
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
                    <a href="#creerCours">Creer cours</a>
                </li>

                <li>
                    <a href="#gestionDisponibilite">Disponibilité</a>
                </li>
                
                <li>
                    <a href="#parametre">Parametre</a>
                </li>
                
                <li>
                    <a href="gestionReserv.php">Reservations</a>
                </li>

                <li>
                    <a href="administration.php">administration</a>
                </li>
            </nav>
        </header>';
}
    
?>

