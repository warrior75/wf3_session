<?php 
require(__DIR__.'/config/db.php'); 

//je vérifie que le bouton submit a été cliqué
if (isset($_POST['action'])) {

	//Affecter une variable à chaque champs récupéré dans $_POST
	$email = trim(htmlentities( $_POST['email'])); // htmlentities:échaper les balises html
	$password = trim(htmlentities( $_POST['password']));//trim: supprime les espaces dans les champs saisis
	$passwordConfirm = trim(htmlentities( $_POST['passwordConfirm']));
	
	//initialisation d'un tableau d'erreur
	$errors = array();

	// check du champs email
	if (empty($email) || (filter_var($email, FILTER_VALIDATE_EMAIL) == 
		false)) {
		$errors['email'] = "Wrong email";
	} elseif (strlen($email) > 60) {
		$errors['email'] = "Email too long";
	} else {
			// je vérifie que l'email est inexistant dans la bdd
			$query = $pdo -> prepare('SELECT email FROM users WHERE email = :email');
			$query -> bindValue(':email',$email,PDO::PARAM_STR);
			$query -> execute();
			//je récupère le résultat sql
			$resulatEmail = $query -> fetch();

			if ($resulatEmail['email']){
				$errors['email'] = "Email already exists";
			}
		}
	// check le champs password
	// 1. vérifier que les 2 password sont identiques
	// 2. vérifier que le password ne fasse pas moin de 6 caractères
	// 3. condition de caractères avec un pattern 	
	if ($password != $passwordConfirm ) {
			$errors['password'] = "Not same passwords";
		}
	elseif(strlen($password) <= 6 ) {
			$errors['password'] = "Password to short";
		}	
	else {
		// Le password contient au moins une lettre
		$containsLetter = preg_match('/[a-zA-Z]/', $password);
		// Le password contient au moins un chiffre
		$containsDigit = preg_match('/\d/', $password);
		// Le password contient au moins un autre caractère spécial
		$containsSpecial = preg_match('/[^a-zA-Z\d]/', $password);
		
		//si une des conditions n'est pas remplie ... erreur 
		if (!$containsLetter || !$containsDigit || !$containsSpecial) {
			$errors['password'] = "Choose a best password with a least one letter, one number and one special character";
		}
	}
	echo "string";
	print_r($errors);
	// si pas d'erreurs, j'enregistre l'utilisateur en bdd
	if (empty($errors)) {
			$query = $pdo -> prepare('INSERT INTO users(email,password,created_at,updated_at)
									  VALUES(:email, :password, NOW(), NOW())');
			$query -> bindValue(':email',$email,PDO::PARAM_STR);
			// hash du password pour la sécurite
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			echo $hashedPassword;						  	
			$query -> bindValue(':password',$hashedPassword,PDO::PARAM_STR);
			$query -> execute();

		}	
}
 ?>