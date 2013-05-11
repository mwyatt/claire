<?php require_once('header.php'); ?>

<div class="content press">
	<h1>Press Releases</h1>

<?php if ($this->get('model_maincontent')) : ?>
	<?php foreach ($this->get('model_maincontent') as $press): ?>

	<article>
		<header>
			<h2><a href="<?php echo $this->get($press, 'guid'); ?>"><?php echo ucfirst($this->get($press, 'title')) ?></a></h2>
		</header>
		<p><?php echo strip_tags(substr($this->get($press, 'html'), 0, 150)) ?></p>
		<footer>
			<a class="read-more" href="<?php echo $this->get($press, 'guid'); ?>">Read full report</a>
			<span class="date"><?php echo date('D jS F Y', $this->get('model_maincontent', 'date_published')) ?></span>
		</footer>
	</article>

	<?php endforeach ?>
<?php endif; ?>	

</div>

<?php require_once('footer.php'); ?>
