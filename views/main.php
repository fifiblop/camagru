<?php
	include("header.php");
	
	$nb_elem_page = 4;
	
	$image_list = Image::getAllImages();
	$nb_images = count($image_list);
	$nb_page = ceil($nb_images/$nb_elem_page);
	
	if (isset($_GET['page'])) {
		$currentPage = $_GET['page'];
		if ($currentPage > $nb_page)
			$currentPage = $nb_page;
	} else
		$currentPage = 1;
		
	$firstImage = ($currentPage - 1) * $nb_elem_page;
	$image_list = Image::getLimitImages($firstImage, $nb_elem_page);
	$row = true;
?>
	<div class="page-wrap">
		<?php if (!$image_list) { ?>
			<label for="">Aucune photo</label>
		<?php } else { 
				foreach ($image_list as $image) {
					if ($row) {
						echo '<div class="row">';
					}
		?>
			<a href="/views/image.php?id=<?= $image[id] ?>" class="card-link"><div class="card">
				<img src="<?= $image[src] ?>">
				<div class="info">
					<ol>
						<div class="link-left">
							<li><label id="user"><?= strtoupper(User::getLoginById(Image::getUserByImageId($image[id]))) ?></label></li>
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
			</div></a>
		<?php
				if (!$row) {
					echo '</div>';	
				}
				$row = !$row;
				}
				if (count($image_list)%2 == 1)
					echo '</div>';
				echo '<div align="center" class="page-selector">';
				for($i=1; $i <= $nb_page; $i++) {
					if ($i == $currentPage)
						echo '<span class="current-page">' . $i . '</span> ';
					else
						echo '<a href="/?page=' . $i .'">' . $i . '</a> ';
				}
				echo '</div>';
			}
		?>
	</div>

<?php
	include("footer.php");
?>
</body>
</html>