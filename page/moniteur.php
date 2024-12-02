<?php
// session_start();
// echo __DIR__."./../../utils/connexion.php";
require_once "../utils/connexionBD.php";
// require_once __DIR__ . "/../../utils/connexion.php";

require_once "../utils/annexe.php";

if(isset($_SESSION["connecte"])){   
    
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";

}
else{
    header("Location : 404.php");
    echo "vous avez pas acces a cette page";
}



echo "page moniteur / admin";