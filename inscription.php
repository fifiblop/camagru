<?php
	include("header.php");
?>
<content class="wrapper">
	<form action="" method="post">
		<img class="user-logo" src="ressources/user.png"><br>
		<label>EMAIL</label><br>
		<input class="champs" type="text" name="email"><br>
		<label>LOGIN</label><br>
		<input class="champs" type="text" name="login"><br>
		<label>MOT DE PASSE</label><br>
		<input class="champs" type="password" name="password"><br>
		<input class="button-valid" type="submit" name="valider" value="VALIDER">
	</form>
</content>
</body>
<?php
	include("footer.php");
?>
</html>