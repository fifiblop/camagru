<?php
	ob_start();
	include("header.php");

	$login = $_POST[login];
	if (!empty($login)) {
		if (!User::loginExist($login))
			$error = "Ce login n'existe pas";
		else {
			$email = User::getEmailByLogin($login);
			$hash = User::getHashByEmail($email);
			Mail::sendRecoverMail($email, $hash);
			$message = "Mail de récuperation envoyé";
		}
	}
	ob_flush();
?>
	<div class="page-wrap">
		<form action="lost.php" method="post">
			<label id="form-title">RECUPERER<br>MOT DE PASSE</label><br>
			<?php if (isset($error)) { ?>
				<label class="form-error"><?php echo $error ?></label><br>
			<?php }; ?>
			<label>LOGIN</label><br>
			<input class="champs" type="text" name="login" style="text-transform:uppercase" required><br>
			<?php if (isset($message)) { ?>
				<label class="form-msg"><?php echo $message ?></label><br>
			<?php }; ?>
			<input class="button-valid" type="submit" name="valider" value="VALIDER"><br/>
		</form>
	</div>
	<?php
		include("footer.php");
	?>
</body>
</html>