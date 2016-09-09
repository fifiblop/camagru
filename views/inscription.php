<?php
	ob_start();
	include("header.php");
	
	$email = $_POST[email];
	$login = $_POST[login];
	$password = $_POST[password];
	
	if (!empty($email) && !empty($login) && !empty(password)) {
		if (User::emailExist($email))
			$error = "Cet email existe déjà";
		else if (User::loginExist($login))
			$error = "Ce login existe déjà";
		else {
			$hash = User::createUser($email, $login, $password);
			Mail::sendRegisterMail($email, $hash);
			$_POST[email] = "";
			$_POST[login] = "";
			$_POST[password] = "";
			$message = "Validez votre inscription par mail";
		}
	}
	ob_flush();
?>
	<div class="page-wrap">
		<form action="inscription.php" method="post">
			<label id="form-title">INSCRIPTION</label><br>
			<?php if (isset($error)) { ?>
				<label class="form-error"><?php echo $error ?></label><br>
			<?php }; ?>
			<label>EMAIL</label><br>
			<input class="champs" type="email" name="email" required><br>
			<label>LOGIN</label><br>
			<input class="champs" type="text" name="login" style="text-transform:uppercase" required><br>
			<label>MOT DE PASSE</label><br>
			<input class="champs" type="password" name="password" minlength="8" required><br>
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