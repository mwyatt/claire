<?php include($this->getTemplatePath('_header')) ?>

<div class="page year-list js-page-year-list">
	<h1 class="page-primary-title">Results by Season</h1>
	<p>Here are all the seasons past and present.</p>

<?php if ($years): ?>

	<div class="years">

	<?php foreach ($years as $year): ?>
		
		<a href="<?php echo $year->getUrl() ?>" class="year"><?php echo $year->getNameFull() ?></a>

	<?php endforeach ?>

		<!-- older -->
		<a href="/archive-older/" class="year">Older</a>
	</div>

<?php else: ?>
	
	<p>No years, not good!</p>

<?php endif ?>
<?php include($this->getTemplatePath('_footer')) ?>