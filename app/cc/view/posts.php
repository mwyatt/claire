<?php require_once('app/cc/view/header.php'); ?>

	<h2>Posts</h2>
		
	<div id="controls">
	
		<form class="liveSearch" action="" method="get">
			<input class="js-liveSearch" name="search" type="text" placeholder="Live Search">		
		</form>		
	
	</div>
	
	<ul class="results">
	
	<?php if ($posts->getResult()) : foreach ($posts->getResult() as $post) : extract($post); ?>
	
		<?php require('app/cc/view/resultRow-post.php') ?>
		
	<?php endforeach; endif; ?>
	
	</ul>

<?php require_once('app/cc/view/footer.php'); ?>