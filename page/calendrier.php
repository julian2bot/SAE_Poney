
<link rel="stylesheet" href="../assets/style/calendrier.css">
<div>

<?php
require_once "../utils/BDD/connexionBD.php";
require_once "../utils/annexe.php";

estAdmin();


// creerCalendrier($bdd, $_SESSION["connecte"]["username"]);
creerCalendrier($bdd, "client1");
echo "<pre>";
// print_r($_SESSION);

// print_r(
    
//     getAllInfoByMonth($bdd, "client1","12", "2023")

// );

// print_r(getInfoByDate($bdd,"client2", "2023-12-01"));
echo "</pre>";
?>
</div>
