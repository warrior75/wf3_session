<?php
session_start(); 
$page='profile';
?>
<!DOCTYPE html>
<html>
<head>
	<title>User Register</title>
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
					<h1>Register</h1>
					<!-- affiche les erreurs srockées en session avec la clé registerErrors -->
					<?php if (isset($_SESSION['registerErrors'])) : ?>
						<div class="alert alert-danger" role="alert">
							<?php foreach ($_SESSION['registerErrors'] as $keyError => $error) : ?>
								<p> <?php echo $error; ?> </p>
							<?php endforeach; ?>	
						</div>
					<!-- il faut supprimer les erreurs une fois affichées sinon elles vont rester -->
					<?php		unset($_SESSION['registerErrors']);?>
					<?php endif; ?>
					<form method="POST" action="registerHandler.php">
					<!-- copié de bootstrap -->
					<div class="form-group">
						<label for="email">Email address</label>
						<input type="email" class="form-control" id="email" name="email" placeholder="Email">
					</div>
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
			<div class="col-md-6" >
				<h1>Login</h1>
				<!-- affiche les erreurs srockées en session avec la clé loginErrors -->
					<?php if (isset($_SESSION['loginErrors'])) : ?>

							<?php if(isset($_SESSION['loginErrors']['email'])) : ?> 
							<div class="alert alert-danger"> 
								<?php echo ($_SESSION['loginErrors']['email']);?> 
								<?php unset($_SESSION['loginErrors']['email']) ?> 
							</div>
							<?php endif;?>
								
							<?php if(isset($_SESSION['loginErrors']['password'])) : ?> 
							<div class="alert alert-danger"> 
								<?php echo ($_SESSION['loginErrors']['password']);?> 
								<?php unset($_SESSION['loginErrors']['password']) ?> 
							</div>
							<?php endif;?>
					
					<!-- il faut supprimer les erreurs une fois affichées sinon elles vont rester -->
					<?php		unset($_SESSION['loginErrors']);?>
					<?php endif; ?>
				<form method="POST" action="loginHandler.php">
					<!-- copié de bootstrap -->
					<div class="form-group">
						<label for="email">Email address</label>
						<input type="email" class="form-control" id="email" name="email" placeholder="Email">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" id="password" name="password" placeholder="Password">
					</div>
					<div class="form-group">
						<a href="">Forgot password ?</a>
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox"> Se souvenir de moi
						</label>
					</div>
					<button type="submit" name="action" class="btn btn-primary">Envoyer</button>
				</form>
			</div>
		</div>
	</div>
</body>
</html>