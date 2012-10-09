<?php require_once('header.php'); ?>

<div class="container">

	<h2>Posts</h2>
		
	<div id="controls">
		<form class="liveSearch" action="" method="get">
			<input class="js-liveSearch" name="search" type="text" placeholder="Live Search">		
		</form>		
	</div>

<?php if ($post->getResult()) : ?>	

	<ul class="results">

	<?php while ($post->nextRow()) : ?>

		<?php include('row-post.php'); ?>

	<?php endwhile; ?>

	</ul>
	
<?php endif; ?>	

</div> <!-- .container -->

<?php require_once('footer.php'); ?>