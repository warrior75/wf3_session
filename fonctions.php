<?php 
	// vérification de la session users
	function checkLoggedIn(){
		
		if (!isset($_SESSION['user'])){
			// si on a oublié d'appeler session_start()
			session_start();
		}
		if (empty($_SESSION['user'])){
			$_SESSION['message'] = "Vous devez vous connecter";
			header('Location: index.php');
			die();
		}
	}

	// Affiche un print_r avec un fond noir
	function pr($varArray){
		echo "<pre style='background: #666; color: #FFF'>";
		print_r($varArray);
		echo "</pre>";
	}
 ?>