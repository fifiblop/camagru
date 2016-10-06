<?php
	ob_start();
	include __DIR__ . "/../autoload.php";
	session_start();
    
    if ($_SESSION[loggued] != "" && isset($_GET[id]) && Image::imageExist($_GET[id])) {
        $user = new User($_SESSION[loggued]);
        if (Likes::userlike($_GET[id], $user->getId()))
            Likes::unlikeImage($_GET[id], $user->getId());
        else
            Likes::likeImage($_GET[id], $user->getId());
        header('Location: ../views/image.php?id=' . $_GET[id]);
    } else {
        header('Location: ../index.php');
    }	
	ob_flush();