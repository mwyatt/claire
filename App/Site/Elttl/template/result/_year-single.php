<?php include $this->getTemplatePath('_header') ?>

<div class="page division-list js-page-division-list">
	<h1 class="page-primary-title">Divisions</h1>
	<p>Here are all the divisions in season <?php echo $yearSingle->getNameFull() ?>.</p>

<?php if (!empty($divisions)) : ?>
	<?php include $this->getTemplatePath('_divisions') ?>
<?php else : ?>
	
	<p>No divisions, not good!</p>

<?php endif ?>
<?php include $this->getTemplatePath('_footer') ?>


<?php echo $this->url->generate('result/year/division/single', ['yearName' => $year->name, 'divisionName' => strtolower($division->name)]) ?>