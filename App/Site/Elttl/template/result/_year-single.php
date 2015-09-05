<?php include $this->getTemplatePath('_header') ?>

<div class="page division-list js-page-division-list">
	<h1 class="page-primary-title">Divisions</h1>
	<p>Here are all the divisions in season <?php echo $yearSingle->getNameFull() ?>.</p>

<?php $year = $yearSingle ?>
<?php if (!empty($divisions)) : ?>

	<div class="home">
		
	<?php include $this->getTemplatePath('_divisions') ?>

	</div>
	
<?php else : ?>
	
	<div class="blankslate mt1">This is an old archive.</div>

<?php endif ?>
<?php include $this->getTemplatePath('_footer') ?>
