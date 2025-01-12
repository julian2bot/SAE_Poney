<?php
require_once __DIR__."/../../BDD/connexionBD.php";
require_once __DIR__."/../../annexe.php";
require_once __DIR__."/../../constante.php";

estConnecte();
// TODO

// require_once __DIR__."/../../BDD/connexionBD.php";
// require_once __DIR__."/../../annexe.php";


echo "<pre>";
print_r($_POST);
echo "</pre>";

if(isset($_POST["cotisation"])){
    $reqInsert = $bdd->prepare("INSERT INTO PAYER (nomCotisation, periode, usernameClient) VALUES (?,?,?)");
    $reqInsert->execute(array($_POST["cotisation"],$_POST["periode"],$_SESSION["connecte"]["username"]));

    createPopUp("Vous avez payé la cotisation, vous pouvez maintenant réserver des cours");

}
header("Location: ../../../../page/adherent.php");
exit;

?>