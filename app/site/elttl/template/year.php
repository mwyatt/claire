<?php include($this->getTemplatePath('_header')) ?>

<div class="page year-list js-page-year-list">
	<h1 class="page-primary-title">Results Archive</h1>
	<p>Here are all the seasons past and present</p>

<?php if ($years): ?>

	<div class="years">

		<!-- older -->
		<a href="/archive-older/" class="year">Older</a>

	<?php foreach ($years as $year): ?>
		
		<a href="<?php echo Helper::urlFriendly($year->getName()) ?>/<?php echo $year->getValue() ? '' : 'result/' ?>" class="year"><?php echo $year->getNameFull() ?></a>

	<?php endforeach ?>

		<!-- present -->
		<a href="../result/" class="year">Current Season</a>
	</div>

<?php else: ?>
	
	<p>No years, not good!</p>

<?php endif ?>
<?php include($this->getTemplatePath('_footer')) ?>
