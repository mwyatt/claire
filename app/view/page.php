<?php require_once($this->pathView() . 'header.php'); ?>

<div class="content page">
	
	<h1><?php echo $mainContent->get('title'); ?></h1>

	<article>
		<header>
			<h2><a href="<?php echo $mainContent->get('guid'); ?>" title="Open article"><?php echo $mainContent->get('title'); ?></a></h2>
		</header>
		
		<p><?php echo $mainContent->get('html'); ?></p>
		<footer>
			<time><?php echo date('d/m/Y', $mainContent->get('date_fulfilled')); ?></time>
		</footer>
	</article>

</div>

<?php require_once($this->pathView() . 'footer.php'); ?>