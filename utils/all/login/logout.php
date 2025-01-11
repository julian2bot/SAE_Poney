<?php
// detruire la session de l'utilisateur, tout suppr puis le deconnecter
session_unset(); 
session_destroy();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', 0, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}

header("Location: ../../../index.php");
exit();