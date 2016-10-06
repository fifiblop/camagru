<?php
	ob_start();
	include("header.php");
	
	if (!isset($_GET[hash]))
		header("Location: ../index.php");
	$password = $_POST[password];
	$hash = $_POST[hash];
	if (!empty($password) && !empty($hash)) {
		if (!Validator::validatePassword($password))
			$error = "Ce mot de passe est invalide";
		else {
			User::changePassword($password, $hash);
			$_SESSION[loggued] = User::getLoginByHash($hash);
			header("Location: ../index.php");
		}
	}
	ob_flush();
?>
	<div class="page-wrap">
		<form action="modif.php" method="post">
			<label id="form-title">CONNEXION</label><br>
			<?php if (isset($error)) { ?>
				<label class="form-error"><?php echo $error ?></label><br>
			<?php }; ?>
			<input type="hidden" name="hash" value="<?= $_GET[hash] ?>">
			<label>NOUVEAU MOT DE PASSE</label><br>
			<input class="champs" type="password" name="password" minlength="8" required><br>
			<input class="button-valid" type="submit" name="valider" value="VALIDER"><br/>
		</form>
	</div>
	<?php
		include("footer.php");
	?>
</body>
</html>