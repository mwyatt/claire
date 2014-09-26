<?php include($this->pathView('_header')) ?>

<div class="page division-list js-page-division-list">
	<h1 class="page-primary-title">Divisions</h1>
	<p>Here are all the divisions in this season.</p>

<?php if ($divisions): ?>

	<div class="divisions">

	<?php foreach ($divisions as $division): ?>
		
		<a href="<?php echo $this->urlFriendly($division->getName()) ?>/" class="division"><?php echo $division->getName() ?></a>

	<?php endforeach ?>

	</div>

<?php else: ?>
	
	<p>No divisions, not good!</p>

<?php endif ?>
<?php include($this->pathView('_footer')) ?>
