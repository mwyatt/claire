<?php include($this->pathView('_header')) ?>

<div class="page division-overview js-page-division-overview">
	<h1 class="page-primary-title"><?php echo $division->getName() ?> division</h1>
	<p class="p">This is an overview for the <?php echo $division->getName() ?> division. The table presenting all the fixtures in a table will appear here in the near future.</p>

<?php include($this->pathView('division/_menu-tables')) ?>
<?php include($this->pathView('_footer')) ?>
