<?php 
session_start(); 
require(__DIR__.'/config/db.php');
//permet d'inclure la labrairie phpmailer grâce à composer
require(__DIR__.'/vendor/autoload.php');

// 1. vérifier que le formulaire a bien été soumis
	
	if (isset($_POST['action'])) {
		
		//2. affecter une viariable à l'email récupéré
		$email = trim(htmlentities($_POST['email']));
		$errors = array();
		$infos = array();

		// check la validité de l'émail

		if (empty($email) || (filter_var($email, FILTER_VALIDATE_EMAIL) == false)){
			$errors['email']='Wrong email';
			} elseif(strlen($email)>60){
				$errors['email']=' Email too long';
			} else {

			//5. Récupération de l'email du user dans la bdd
			$query = $pdo -> prepare('SELECT * FROM users WHERE email = :email');//on récupère tout les champs
			$query -> bindValue('email',$email,PDO::PARAM_STR);
			$query -> execute();
			$infosUser = $query -> fetch();

				if(!$infosUser){
					$errors['email']=' User not find';// le user n'est pas présent dans la bdd
				} else {
					// 6. générer un Token
					$token = md5(uniqid(mt_rand(),true));

					// 7. Date d'expiration du Token
					$expireToken = date("Y-m-d H:i:s",strtotime('+ 1 day'));

					// 8. Updater le user dans la bdd grâce à ces nouvelles informations
					$query = $pdo -> prepare ('UPDATE users 
											   SET token = :token, expire_token = :expire_token , updated_at = NOW()
											   WHERE id = :id ');
 					$query -> bindValue(':token',$token,PDO::PARAM_STR);
 					$query -> bindValue(':expire_token',$expireToken,PDO::PARAM_STR);
 					$query -> bindValue(':id',$infosUser['id'],PDO::PARAM_INT);
 					$query -> execute();

					// le user est présent alors on génère un nouveau mot de passe
					$infos['email'] = 'Un email a été envoyé pour réinitialiser votre mot de passe';

					//equivalent à http://localhost/wf3_session_2/forgotPassword.php?token=*****&email=******
					$resetLink = 'http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF']).'/resetPassword.php?token='.$token.'&email='.$email;
					// mail($email, 'Reset Password', 'Pour redéfinir votre mot de passe cliquer sur ce lien :'.$resetLink);

					$mail = new PHPMailer;

					$mail->SMTPDebug = 3;                               	// Enable verbose debug output

					 $mail->isSMTP();                                      // Set mailer to use SMTP
					 $mail->Host = 'smtp.gmail.com'; 						// Specify main and backup SMTP servers
					 $mail->SMTPAuth = true;                               // Enable SMTP authentication
					 $mail->Username = 'wf3.noreply@gmail.com';              // SMTP username
					 $mail->Password = 'merciwf3';                           // SMTP password
					 $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
					 $mail->Port = 465;                                    // TCP port to connect to

					$mail->setFrom('admin@wf3.com', 'Admin');
					$mail->addAddress($email, 'Joe User');     // Add a recipient

					$mail->isHTML(true);                                  // Set email format to HTML

					$mail->Subject = 'Reset password';
					$mail->Body    = 'pour redéfinir votre mot de passe cliquez sur ce lien :<a href="'.$resetLink.'">Lien</a>';
					$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

					if(!$mail->send()) {
					    echo 'Message could not be sent.';
					    echo 'Mailer Error: ' . $mail->ErrorInfo;
					} else {
					    echo 'Message has been sent';
					}
				}
			}
		}
 ?>



 <!DOCTYPE html>
 <html>
	 <head>
		<title>Wf3 session</title>
		<meta charset="utf-8">
		<!-- Latest compiled and minified Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	</head>
	 <body>
		
	 	<div class="container">
	 		<div class="row">
	 			<div class="col-md-6">
	 			<h1>Forgot Password</h1>
	 				<?php if (!empty($errors['email'])) :?>
	 					<div class="alert alert-danger" role="alert">
	 						<?php  foreach ($errors as $error) :?>
	 						<p> <?php echo $error ; ?> </p>
	 						<?php endforeach; ?>
	 					</div>	
	 				<?php endif; ?>
	 					<?php if (!empty($infos['email'])) :?>
	 					<div class="alert alert-info" role="alert">
	 						<?php  foreach ($infos as $info) :?>
	 						<p> <?php echo $info ; ?> </p>
	 						<?php endforeach; ?>
	 					</div>	
	 					<?php endif;?>
	 				<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" >
	 					<div class="form-group">
	 						<label for="email">Email address</label>
	 						<input type="email" class="form-control" id="email" name="email" placeholder="Email">
	 					</div>
	 					<button type="submit" name="action" class="btn btn-primary">Submit</button>

	 				</form>
	 			</div>
	 		</div>
	 	</div>
	 </body>
 </html>