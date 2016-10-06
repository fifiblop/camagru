<?php
	ob_start();
	include("header.php");
	session_start();
    if ($_SESSION[loggued] == "")
        header("Location: ../index.php");
    $user = new User($_SESSION[loggued]);
    $image_list = Image::getImagesByUser($user->getId());
	ob_flush();
?>
	<div class="page-wrap">
        <div class="profil">
            <div class="profil-title">
                <?= $user->getLogin() ?><br/>
                <a href="settings.php"><span id="modif">MODIFICATIONS</span></a>
            </div>
            <div class="profil-info"><?= $user->getEmail() ?></div>
        <?php 
            if (!$image_list) {
                echo 'Aucune photo';    
            } else {
                echo '<div id="profil-gallery">';
                foreach($image_list as $image) {
                    echo '<div class="profil-img-container">';
                    echo '<a href="/views/image.php?id=' . $image[id] . '"><img class="profil-images" src="' . $image[src] . '"></a>';
                    echo '<a href="/actions/delete.php?id=' . $image[id] . '"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                    echo '</div>';
                }
                echo '</div>';
            } 
        ?>
    </div>    
    </div>
	<?php
		include("footer.php");
	?>
</body>
</html>