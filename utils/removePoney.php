<?php
require_once "../utils/connexionBD.php";
if(!isset($_SESSION["connecte"]) OR $_SESSION["connecte"]["role"] !== "admin"){
    header("Location: ../");
}

if(isset($_GET["idPoney"]))
{

    
    // ! reservation a faire
    $sql = "DELETE FROM PONEY WHERE idPoney= ? ";
    $stmt = $bdd->prepare($sql);
    $stmt ->execute([$_GET["idPoney"]]);
}



?>