<?php
	ob_start();
	include("header.php");
	session_start();
	if ($_SESSION[loggued] == "")
        header("Location: inscription.php");
	$image = Image::getImageById($_GET[id]);
	$image = $image[0];
	$comments = Comment::getAllCommentsByIdImage($_GET[id]);
	$user = new User($_SESSION[loggued]);
	ob_flush();
?>
	<div class="page-wrap">
		<?php if (!$image) {
			echo "Cette image n'existe pas";
		} else { ?>
		<div class="image-page">
			<div class="static">
				<img src="<?= $image[src] ?>">
				<div class="info">
					<ol>
						<div class="link-left">
							<li><label id="user"><?= strtoupper(User::getLoginById($image[id_user])) ?></label></li>
						</div>
						<div class="link-right">
							<li><label id="likes"><?= Likes::getNbLikesByIdPhoto($image[id]) ?> <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
		</label></li>
							<li><label>•</label></li>
							<li><label id="commentaires"><?= Comment::getNbCommentByIdPhoto($image[id]) ?> <i class="fa fa-comment-o" aria-hidden="true"></i></label></li>
							<li><label>•</label></li>
							<li><label id="date"><?= $image[date] ?></label></li>
						</div>
					</ol>
				</div>
			</div>
			<div id="like">
				<?php if (Likes::userlike($image[id], $user->getId())) { ?>
					<a href="../actions/like.php?id=<?= $image[id] ?>"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a>
				<?php } else { ?>
					<a href="../actions/like.php?id=<?= $image[id] ?>"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a>
				<?php } ?>
			</div>
			<div id="commentaires">
				<form id="comment-area" action="../actions/comment.php" method="POST">
					<input type="hidden" name="id_image" value="<?= $_GET[id] ?>"/>
					<input type="hidden" name="id_user" value="<?= $user->getId() ?>"/>
					<input type="text" name="comment" id="comment-box" maxlength="250"/>
					<input class="button-comment" type="submit" name="commenter" value="COMMENTER"><br/>
				</form>
				<?php if (!$comments) { ?>
					<label>aucun commentaire</label>	
				<?php } else {
					foreach($comments as $com) {
					echo "<div class='comment'>" . User::getLoginById($com[id_user]) . " : " . $com[text] . "</div>";
				} }?>
			</div>
		</div>
		<?php } ?>
	</div>
	<?php
		include("footer.php");
	?>
</body>
</html>