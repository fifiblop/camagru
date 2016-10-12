<?php
	include __DIR__ . "/../autoload.php";
	session_start();
	
    $text = $_POST[comment];
    $id_image = $_POST[id_image];
    $id_user = $_POST[id_user];
    if (!empty($text) && !empty($id_image) && !empty($id_user)) {
        if (strlen($text) > 250)
            header('Location: ../views/image.php?id=' . $id_image);
        Comment::commentImage(htmlspecialchars($text), $id_image, $id_user);
        Mail::sendCommentMail(User::getEmailByLogin(Image::getUserByImageId($id_image)), $text, $_SESSION[loggued], $id_image);
        header('Location: ../views/image.php?id=' . $id_image);
    } else if (empty($text)) {
        header('Location: ../views/image.php?id=' . $id_image);
    } else {
        header('Location: ../index.php');
    }