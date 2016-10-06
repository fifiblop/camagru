<?php 
	ob_start();
	include("header.php");
	session_start();
    if ($_SESSION[loggued] == "")
        header("Location: ../index.php");
    $user = new User($_SESSION[loggued]);
    
	$email = $_POST[email];
	$password = $_POST[password];
	
	if (!empty($email) && $email != $user->getEmail()) {
		if (!Validator::validateEmail($email))
			$error = "Cet email n'est pas compatible";
		else if (User::emailExist($email))
			$error = "Cet email existe déjà";
		else {
			User::changeEmail($email, $user->getHash());
			$_POST[email] = "";
			$message = "Modification réussi";
		}
	}
	
	if (!empty($password)) {
		if (!Validator::validatePassword($password))
			$error = "Ce mot de passe est invalide";
		else {
			User::changePassword($password, $user->getHash());
			$_POST[password] = "";
			$message = "Modification réussi";
		}
	}
	ob_flush();
?>
	<div class="page-wrap">
		<form action="settings.php" method="POST">
			<label id="form-title">MODIFICATION</label><br>
			<?php if (isset($error)) { ?>
				<label class="form-error"><?php echo $error ?></label><br>
			<?php }; ?>
			<label>EMAIL</label><br>
			<input class="champs" type="email" name="email" value="<?= $user->getEmail() ?>"><br>
			<label>NOUVEAU MOT DE PASSE</label><br>
			<input class="champs" type="password" name="password" minlength="8"><br>
			<?php if (isset($message)) { ?>
				<label class="form-msg"><?php echo $message ?></label><br>
			<?php }; ?>
			<input class="button-valid" type="submit" name="valider" value="VALIDER">
		</form>
	</div>

	<?php
		include("footer.php");
	?>
</body>
</html>