<?php require_once('header.php'); ?>

<article class="content press single">
	<!-- <a href="" class="bread"></a> -->
	<header>
		<h1><?php echo $this->get('model_maincontent', 'title'); ?></h1>
		<span class="date"><?php echo date('D jS F Y', $this->get('model_maincontent', 'date_published')) ?></span>
	</header>
	<div class="html">
		<?php echo $this->get('model_maincontent', 'html'); ?>
	</div>
	<footer>
		Share this press release: <strong>twitter</strong> <strong>facebook</strong>
	</footer>
</article>

<?php require_once('footer.php'); ?>
