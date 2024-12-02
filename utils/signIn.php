<?php

require_once "./connexionBD.php";


if(isset($_POST['fromSignIn']))
{
	$username = htmlspecialchars($_POST['NameSignIn']);
	$nom = htmlspecialchars($_POST['nomSignIn']);
	$prenom = htmlspecialchars($_POST['prenomSignIn']);
	$mail = htmlspecialchars($_POST['Mail']);
	$pass = /*password_hash*/sha1($_POST['Password']/*, PASSWORD_DEFAULT*/);
	$pass2 = /*password_hash*/sha1($_POST['RePassword']/*, PASSWORD_DEFAULT*/);
	
	if(!empty($_POST['NameSignIn']) AND !empty($_POST['nomSignIn']) AND !empty($_POST['prenomSignIn']) AND !empty($_POST['Mail']) AND !empty($_POST['Password']) AND !empty($_POST['RePassword']))
	{
		
		
		// $prenomlength = strlen($username);
        if(strlen($username) <= 32)
		{	
            
            if(strlen($prenom) <= 100)
            {	
                
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
                			// $erreur = "Votre compte a bien été créé!";
							$_SESSION["connecte"] = array(
									"username" => $username, 
									"prenom" => $prenom, 
									"nom" => $nom, 
									"mail" => $mail
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
		$erreur =  "Tous les champs doivent être complétés!";
	}

}
else
{
	$erreur =  "Tous ...!";
}

// retourne sur la page index avec l'erreur s'il y en a une 
if($erreur){
	header("Location: ../index.php?erreurSignIn=$erreur");
}
else{
	header("Location: ../index.php");
}
?>