<?php require_once('header.php'); ?>

<div class="content minutes">
	<h1>Minutes</h1>

<?php if ($this->get('model_maincontent')) : ?>
	<?php foreach ($this->get('model_maincontent') as $minute): ?>

	<article>
		<h2><a href="<?php echo $this->get($minute, 'media'); ?>" target="_blank"><?php echo date('D jS F Y', $this->get('model_maincontent', 'date_published')) ?></a></h2>
		<a class="button" href="<?php echo $this->get($minute, 'media'); ?>" target="_blank">Download</a>
	</article>

	<?php endforeach ?>
<?php endif; ?>	

</div>

<?php require_once('footer.php'); ?>
