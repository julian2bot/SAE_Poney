<?php

if($_SESSION["connecte"]["role"] ==="client"){
    
    echo '
    <header>
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
elseif($_SESSION["connecte"]["role"] ==="client"){
echo 
    '<header>
        <nav>
        <ul>    
            <li>
            <a href="#">Planning</a>
            </li>
            
            <li>
            <a href="#">Reserver cours</a>
            </li>
            
            <li>
            <a href="#">Parametre</a>
            </li>
        </nav>
    </header>';
}
    
?>

