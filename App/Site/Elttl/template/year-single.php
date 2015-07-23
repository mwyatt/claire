<?php include $this->getTemplatePath('_header') ?>

<div class="page year-single js-page-year-single">
	<h1 class="page-primary-title">Season <?php echo $year->getNameFull() ?></h1>
	<p>Here are all the results for the season <?php echo $year->getNameFull() ?>.</p>
	<div class="year-single-result">
		
<?php echo $year->getValue() ?>

	</div>

<?php include $this->getTemplatePath('_footer') ?>
