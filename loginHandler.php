<?php
session_start(); 
require(__DIR__.'/config/db.php'); 

// Vérifier que le button submit a été cliqué

if (isset($_POST['action'])) {
	$email = trim(htmlentities($_POST['email']));
	$password = trim(htmlentities($_POST['password']));

	// Initialisation d'un tableau d'erreurs
	$errors = array();

	// 1. récupération de l'utilisateur dans la bdd grâce à son email

	$query = $pdo -> prepare('SELECT email,password FROM users WHERE email = :email');
	$query -> bindValue('email',$email,PDO::PARAM_STR);
	$query -> execute();
	$userInfos = $query -> fetch();

	if ($userInfos){
		
		//password_verify est compatible >= PHP 5.5
		if (password_verify($password,$userInfos['password'])) {
			
			//On stocke le user en session mais on retire le password avant
			unset($userInfos['password']);
			$_SESSION['user']=$userInfos;
			header('Location: profile.php');
			die();
		}
		else{
			$errors['password']="Password invalid";
		}
	} else {
		$errors['email']="user with email not find";
	}
	
	$_SESSION['loginErrors'] = $errors;
	header("Location: index.php");
	die();

}


 ?>