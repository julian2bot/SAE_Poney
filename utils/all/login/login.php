<?php
// code pour se login verifier s'il est bien dans la BD et mettre toute les valeurs dans le $_SESSION

require_once __DIR__."/../../BDD/connexionBD.php";
require_once __DIR__."/../../annexe.php";



if(isset($_POST['fromLogin'])){

	$username = htmlspecialchars($_POST['Name']);
	$pass2 = /*password_hash*/sha1($_POST['PassWordLogin']/*, PASSWORD_DEFAULT*/);
	
	if(!empty($_POST['Name']) AND !empty($_POST['PassWordLogin'])){
		
		
		$requser = $bdd-> prepare("SELECT * FROM PERSONNE WHERE username = ? AND mdp = ? ");
		$requser->execute(array($username, $pass2));
		$userexist = $requser->rowCount();
		if($userexist == 1)
		{
			$userinfo = $requser->fetch();

			$_SESSION["connecte"] = array(
				"username" => $userinfo['username'], 
				"prenom" => $userinfo['prenomPersonne'], 
				"nom" => $userinfo['nomPersonne'], 
				"mail" => $userinfo['mail'],
				"role" =>  getRole($bdd, $username),
				"info" => getInfo($bdd, $username)

			);
		}  
		else
		{
			$erreur = "Mauvais mail ou mot de passe";
		}

		
	}
	else{
		$erreur =  "Tous les champs doivent être complétés!";
	}

}


// retourne sur la page index avec l'erreur s'il y en a une 
if($erreur){
	header("Location: ../../../index.php?erreurLogin=$erreur");
	exit;
}
else{
	header("Location: ../../../index.php");
	exit;
}
?>