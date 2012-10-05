<?php require_once('app/cc/view/header.php'); ?>

	<h2>Posts</h2>
		
	<div id="controls">
		<form class="liveSearch" action="" method="get">
			<input class="js-liveSearch" name="search" type="text" placeholder="Live Search">		
		</form>		
	</div>

<?php if ($posts->getResult()) : ?>	

	<ul class="results">

	<?php while ($posts->nextRow()) : ?>

		<?php require('app/cc/view/row-post.php') ?>

	<?php endwhile; ?>

	</ul>
	
<?php endif; ?>	

<?php require_once('app/cc/view/footer.php'); ?>