<?php session_start();
	
	require(__DIR__.'/fonctions.php');


	// je checke que l'utilisateur est bien logué
	checkLoggedIn();

	// if (empty($_SESSION['user'])){
	// 	// one redirige le user vers l'accueil
	// 	header('Location: index.php');
	// 	// force l'arrêt de cette page
	// 	die();
	// }

	$page = 'home';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Wf3 session</title>
	<meta charset="utf-8">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

</head>
<body>
	<?php	include(__DIR__.'/include/nav.php'); ?>
	
	<div class="container">
		<div class="row">
			<div class="col-md-6">
			<h1>Home</h1>
			<?php if (isset($_SESSION['user'])) :?>
			<?php pr($_SESSION['user']); ?>
			<?php endif; ?>
			<p>Bienvenue <?php echo $_SESSION['user']['email']; ?></p>
			<p>Cette page n'est accessible que pour les nouveaux utilisateurs ou
			les utilisateurs connectés</p>
			</div>
		</div>
	</div>
</body>
</html>