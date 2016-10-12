<?php
	ob_start();
	include("header.php");
	session_start();

	$login = $_POST[login];
	$password = hash("whirlpool", $_POST[password]);
	
	if (!empty($login) && !empty($password)) {
		if (!Validator::validateLogin($login))
			$error = "Ce login n'est pas compatible";
		else if (!User::loginExist($login))
			$error = "Ce login n'existe pas";
		else if ($password != User::getPasswordByLogin($login))
			$error = "Mauvais mot de passe";
		else if (!User::isActive($login))
			$error = "Ce compte n'es pas activé";
		else {
			$_SESSION[loggued] = $login;
			$_POST[email] = "";
			$_POST[login] = "";
			$_POST[password] = "";
			header("Location: ../index.php");
		}
	}
	ob_flush();
?>
	<div class="page-wrap">
		<form action="#" method="post">
			<label id="form-title">CONNEXION</label><br>
			<?php if (isset($error)) { ?>
				<label class="form-error"><?php echo $error ?></label><br>
			<?php }; ?>
			<label>LOGIN</label><br>
			<input class="champs" type="text" name="login" style="text-transform:uppercase" required><br>
			<label>MOT DE PASSE</label><br>
			<input class="champs" type="password" name="password" minlength="8" required><br>
			<input class="button-valid" type="submit" name="valider" value="VALIDER"><br/>
			<a href="lost.php" class="lost-mail">J'ai perdu mon mot de passe</a>
		</form>
	</div>
	<?php
		include("footer.php");
	?>
</body>
</html>