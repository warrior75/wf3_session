<?php 
	// même pour effacer une variable en session, on doit utiliser session_start()
	session_start();

	// supprime la variable SUPER GLOBALE $_SESSION
	unset($_SESSION['user']);

	//Création d'un message de déconnexion
	$_SESSION['message']="Vous avez été déconnecté du service";

	header('Location: index.php');
	die();
 ?>