<?php require_once('header.php'); ?>

	<h2>Posts</h2>
		
	<div id="controls">
		<form class="liveSearch" action="" method="get">
			<input class="js-liveSearch" name="search" type="text" placeholder="Live Search">		
		</form>		
	</div>

<?php if ($content->getResult()) : ?>	

	<ul class="results">

	<?php while ($content->nextRow()) : ?>

		<?php require_once('row-post.php'); ?>

	<?php endwhile; ?>

	</ul>
	
<?php endif; ?>	

<?php require_once('footer.php'); ?>