<?php
	include("header.php");
?>
	<form action="src/register.php" method="post">
		<!-- <img class="user-logo" src="ressources/user.png"><br> -->
		<label>EMAIL</label><br>
		<input class="champs" type="text" name="email"><br>
		<label>LOGIN</label><br>
		<input class="champs" type="text" name="login" style="text-transform:uppercase"><br>
		<label>MOT DE PASSE</label><br>
		<input class="champs" type="password" name="password"><br>
		<input class="button-valid" type="submit" name="valider" value="VALIDER">
	</form>
</body>
<?php
	include("footer.php");
?>
</html>