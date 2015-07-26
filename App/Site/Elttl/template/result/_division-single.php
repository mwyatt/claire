<?php include $this->getTemplatePath('_header') ?>

<div class="page division-overview js-page-division-overview">
	<h1 class="page-primary-title"><?php echo $division->name ?> division</h1>
	<p class="p">This is an overview for the <?php echo $division->name ?> division.</p>

<?php include $this->getTemplatePath('division/_menu-tables') ?>
<?php include $this->getTemplatePath('division/_fixture-summary-table') ?>
<?php include $this->getTemplatePath('_footer') ?>
