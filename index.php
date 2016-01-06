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
				<div class="col-md-6">
					<h1>Register</h1>
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