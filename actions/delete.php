<?php
	ob_start();
	include __DIR__ . "/../autoload.php";
	session_start();
	
	if (isset($_GET[id]) || $_SESSION[loggued] != "") {
	    $user = new User($_SESSION[loggued]);
	    $image = Image::getImageById($_GET[id]);
	    if ($user->getId() != $image[0][id_user])
	        header('Location: ../index.php');  
	    else {
		    unlink($image[0][src]);
		    Likes::deleteLikesById($image[0][id]);
		    Comment::deleteCommentsById($image[0][id]);
		    Image::deleteImageById($image[0][id]);
		    header('Location: ../views/home.php');
	    }
	} else {
	  header('Location: ../index.php');  
	}
    ob_flush();