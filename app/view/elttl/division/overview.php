<?php include($this->pathView('_header')) ?>

<div class="page division-overview js-page-division-overview">
	<h1 class="page-primary-title"><?php echo $division->getName() ?> division</h1>
	<p>This is an overview for the <?php echo $division->getName() ?> division.</p>
	<p>table summary for fixtures</p>
	<div class="division-overview-options">
		
<?php foreach (array('merit', 'league') as $option): ?>
	
		<a href="<?php echo $option ?>/" class="division-overview-option"><?php echo ucfirst($option) ?> table</a>

<?php endforeach ?>

	</div>

<?php include($this->pathView('_footer')) ?>
