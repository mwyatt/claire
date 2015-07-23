<?php include $this->getTemplatePath('_header') ?>

<div class="page division-list js-page-division-list">
	<h1 class="page-primary-title">Divisions</h1>
	<p>Here are all the divisions in season <?php echo $yearSingle->getNameFull() ?>.</p>

<?php if ($divisions): ?>

	<div class="divisions">

	<?php foreach ($divisions as $division): ?>
		
		<a href="<?php echo $division->getUrl($yearSingle) ?>" class="division"><?php echo $division->getName() ?></a>

	<?php endforeach ?>

	</div>

<?php else: ?>
	
	<p>No divisions, not good!</p>

<?php endif ?>
<?php include $this->getTemplatePath('_footer') ?>
