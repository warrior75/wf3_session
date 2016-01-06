<?php 
require(__DIR__.'/config/db.php'); 

//je vérifie que le bouton submit a été cliqué
if (isset($_POST['action'])) {

	//Affecter une variable à chaque champs récupéré dans $_POST
	$email = trim(htmlentities( $_POST['email'])); // htmlentities:échaper les balises html
	$password = trim(htmlentities( $_POST['password']));//trim: supprime les espaces dans les champs saisis
	$passwordConfirm = trim(htmlentities( $_POST['passwordConfirm']));

	echo $email;
	echo $password;
	echo $passwordConfirm;

	
}
 ?>