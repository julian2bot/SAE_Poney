<?php
require_once "./connexionBD.php";
require_once "./annexe.php";

estConnecte();
estMoniteur();

echo "<pre>";
print_r($_GET);
echo "</pre>";
?>
