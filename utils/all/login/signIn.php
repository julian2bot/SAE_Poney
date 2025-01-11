<?php
// code pour s'inscrire sur le site et ajouter les informations dans une BD
require_once __DIR__."/../../BDD/connexionBD.php";
require_once __DIR__."/../../annexe.php";

if(isset($_POST['fromSignIn']))
{
	$username = htmlspecialchars($_POST['NameSignIn']);
	$nom = htmlspecialchars($_POST['nomSignIn']);
	$prenom = htmlspecialchars($_POST['prenomSignIn']);
	$mail = htmlspecialchars($_POST['Mail']);
	$poids = htmlspecialchars($_POST['poids']);
	$pass = /*password_hash*/sha1($_POST['Password']/*, PASSWORD_DEFAULT*/);
	$pass2 = /*password_hash*/sha1($_POST['RePassword']/*, PASSWORD_DEFAULT*/);
	
	if(!empty($_POST['poids']) AND !empty($_POST['NameSignIn']) AND !empty($_POST['nomSignIn']) AND !empty($_POST['prenomSignIn']) AND !empty($_POST['Mail']) AND !empty($_POST['Password']) AND !empty($_POST['RePassword']))
	{
		
		if((int)$poids > 0){

				
				// $prenomlength = strlen($username);
				if(strlen($username) <= 32){	
					
					if(strlen($prenom) <= 100){	
					
					if(strlen($nom) <= 100)
					{	

						$reqmail = $bdd->prepare("SELECT * FROM PERSONNE WHERE mail=? OR username = ?");
						$reqmail->execute(array($mail, $username ));
						$mailexist = $reqmail->rowCount();
						if($mailexist == 0)
						{
							if($pass == $pass2)
							{
								$insertmbr = $bdd->prepare("INSERT INTO PERSONNE(username, mdp, prenomPersonne, nomPersonne, mail) VALUES(?, ?, ?, ?, ?)");
								$insertmbr->execute(array($username, $pass, $prenom, $nom, $mail));
								
								$insertClient = $bdd->prepare("INSERT INTO CLIENT(usernameClient, dateInscription, poidsClient) VALUES(?, ?, ?)");
								$insertClient->execute(array($username, date('Y-m-d'), (int)$poids));

								// $erreur = "Votre compte a bien été créé!";
								$_SESSION["connecte"] = array(
										"username" => $username, 
										"prenom" => $prenom, 
										"nom" => $nom, 
										"mail" => $mail,
										"role" =>  getRole($bdd, $username),
										"info" => array($username, date('Y-m-d'), (int)$poids)
									);
							}
							else
							{
								$erreur =  "vos mots de passes ne sont pas indentique !";
							}
						}
						else
						{
							$erreur =  "votre addresse mail ou username est deja utilisée!";
						}
					
					}
					else
					{
						$erreur =  "votre mon ne doit pas etre au dessus de 100 caracteres!"; 
					}
				}
				else
				{
					$erreur =  "votre premon ne doit pas etre au dessus de 100 caracteres!"; 
				}
			}
			else
			{
				$erreur =  "votre pseudo ne doit pas etre au dessus de 32 caracteres!"; 
			}
		}

		else
		{
			$erreur =  "Votre poids doit etre valide!"; 
		}
	
	}
	
	else
	{
		$erreur =  "Tous les champs doivent être complétés!";
	}

}
else
{
	$erreur =  "Tous ...!";
}

// retourne sur la page index avec l'erreur s'il y en a une 
if($erreur){
	header("Location: ../../../index.php?erreurSignIn=$erreur");
	exit;
}
else{
	header("Location: ../../../index.php");
	exit;

}?>