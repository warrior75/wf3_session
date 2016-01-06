<?php 
	// même pour effacer une variable en session, on doit utiliser session_start()
	session_start();

	unset($_SESSION['user']); // supprime la variable SUPER GLOBALE $_SESSION
	header('Location: index.php');
	die();
 ?>