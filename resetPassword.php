<?php 
session_start(); 
require(__DIR__.'/config/db.php');
	if (empty($_GET['token']) || empty($_GET['email'])){
		header('Location: index.php');
		die();
	} else {
		$errors = array();

		$email = $_GET['email'];
		$token = $_GET['token'];

		// je récupère le user en bdd et je vérifie le token après

		$query = $pdo -> prepare('SELECT * FROM users WHERE email = :email');
		$query -> bindValue(':email',$email,PDO::PARAM_STR);
		$query -> execute();
		$infosUser = $query -> fetch();

		if ($infosUser){
			// 1. je vérifie que le token correspond
			if ($token != $infosUser['token']){
				header('Location: index.php');
				die();
			}

			// 2. je vérifie que le token n'a pas exprié
			// si le token est expiré
			if ($infosUser['expire_token'] < date("Y-m-d H:i:s")) {
				header('Location: index.php');
				die();
			}
		}
	}

	// ici je traite le POST pour changer le mot de passe
	if (isset($_POST['action'])) {
		$password = trim(htmlentities($_POST['password']));
		$passwordConfirm = trim(htmlentities($_POST['passwordConfirm']));
	

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

	// s'il n'y a pas d'erreur
		if (empty($errors)) {
			$query = $pdo -> prepare('UPDATE users
									  SET password = :password, token = NULL, expire_token = NULL, updated_at = NOW()
									  WHERE id = :id');
			// hash du password pour la sécurite
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			echo $hashedPassword;						  	
			$query -> bindValue(':password',$hashedPassword,PDO::PARAM_STR);
			$query -> bindValue(':id',$infosUser['id'],PDO::PARAM_INT);
			$query -> execute();
			
			if ($query->rowCount() > 0) {
				// récupération de l'utilisateur depuis la bdd
				// pour l'affecter à une variable de sessions
				$query = $pdo -> prepare('SELECT * FROM users WHERE id = :id');
				$query->bindValue(':id',$infosUser['id'],PDO::PARAM_INT);
				$query->execute();
				$resultUser = $query->fetch();
				
				//On stocke le user en session mais on retire le password avant
				unset($resultUser['password']);
				$_SESSION['user']=$resultUser;
				// On redirige l'utilisateur
				header("Location: profile.php");
				die();
				}
			} 
		
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Password Reset</title>
	<meta charset="utf-8">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

</head>
<body>
	
	<div class="container">
			<div class="row">

			<?php if (isset($_SESSION['message'])) :?>
			<div class="alert alert-info" >
				<!-- même démarche pour mes erreurs en bas -->
				<?php	echo $_SESSION['message']; ?>
				<?php	unset($_SESSION['message']); ?>
			</div>
			<?php endif; ?>
				<div class="col-md-6">
					<h1>Reset Password</h1>
					<!-- affiche les erreurs srockées en session avec la clé registerErrors -->
					<?php if (isset($errors['password'])) : ?>
						<div class="alert alert-danger" role="alert">
							<?php foreach ($errors as $error) : ?>
								<p> <?php echo $error; ?> </p>
							<?php endforeach; ?>	
						</div>
					<!-- il faut supprimer les erreurs une fois affichées sinon elles vont rester -->
					<?php		unset($_SESSION['registerErrors']);?>
					<?php endif; ?>
					<form method="POST" action="#">	
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" id="password" name="password" placeholder="Password">
					</div>
					<div class="form-group">
						<label for="passwordConfirm">Confirm Password</label>
						<input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" placeholder="Password Confirmation">
					</div>
					<button type="submit" name="action" class="btn btn-primary">Envoyer</button>
				</form>
			</div>
			
		</div>
	</div>
</body>
</html>