<?php

abstract class Mail {

	static function sendRegisterMail($email, $hash) {
		$subject = "CAMAGRU - INSCRIPTION";
		$message = "<html>
					<body>
					<h2>salut<h2>
					<a href='http://localhost:8080/camagru/actions/activation.php?hash=" . $hash . 
					"&email=" . $email . "'>clique ici</a>
					</body>
					</html>";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
     	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: camagru@yopmail.com' . "\r\n" .
		$headers .= 'Reply-To: camagru@yopmail.com' . "\r\n" .
		$headers .= 'X-Mailer: PHP/' . phpversion();
		mail($email, $subject, $message, $headers);
	}

	static function sendRecoverMail($email, $hash) {
		$subject = "CAMAGRU - RECUPERER MOT DE PASSE";
		$message = "<html>
					<body>
					<h2>salut<h2>
					<a href='http://localhost:8080/camagru/views/modif.php?hash=" . $hash . "'>clique ici</a>
					</body>
					</html>";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
     	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: camagru@yopmail.com' . "\r\n" .
		$headers .= 'Reply-To: camagru@yopmail.com' . "\r\n" .
		$headers .= 'X-Mailer: PHP/' . phpversion();
		mail($email, $subject, $message, $headers);
	}
	
	static function sendCommentMail($email, $user, $id_image) {
		$subject = "CAMAGRU - RECUPERER MOT DE PASSE";
		$message = "<html>
					<body>
					<h2>salut<h2>
					<p>" . $user . " a commenté votre image</p><br/>
					<a href='http://localhost:8080/camagru/views/image.php?id=" . $id_image . "'>clique ici</a>
					</body>
					</html>";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
     	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: camagru@yopmail.com' . "\r\n" .
		$headers .= 'Reply-To: camagru@yopmail.com' . "\r\n" .
		$headers .= 'X-Mailer: PHP/' . phpversion();
		mail($email, $subject, $message, $headers);
	}
}